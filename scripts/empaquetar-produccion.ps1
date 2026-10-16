# Arma el .zip para subir a producción (hosting compartido: el servidor no compila ni tiene Node).
#
# Uso (desde la raíz del proyecto, en PowerShell):
#   powershell -ExecutionPolicy Bypass -File scripts\empaquetar-produccion.ps1
#
# Trabaja sobre una copia en una carpeta temporal: tu proyecto local (vendor con dependencias
# de desarrollo, .env, base local) no se modifica. Resultado: avanzia-landing-produccion.zip

$ErrorActionPreference = 'Stop'
$raiz = Split-Path -Parent $PSScriptRoot
$staging = Join-Path $env:TEMP 'avanzia-landing-produccion'
$zip = Join-Path $raiz 'avanzia-landing-produccion.zip'

Write-Host '1/4 Compilando el frontend (npm run build)...'
Push-Location $raiz
npm run build
if ($LASTEXITCODE -ne 0) { throw 'Falló npm run build' }
Pop-Location

Write-Host '2/4 Copiando el proyecto sin archivos de desarrollo ni secretos...'
if (Test-Path $staging) { Remove-Item $staging -Recurse -Force }
# /XD carpetas excluidas, /XF archivos excluidos. Nunca: .env, public/hot (rompería el sitio), node_modules.
robocopy $raiz $staging /E /NFL /NDL /NJH /NJS /NP `
    /XD node_modules vendor .git .github .claude .vscode .idea tests archivo `
        (Join-Path $raiz 'storage\logs') (Join-Path $raiz 'storage\framework\cache') `
        (Join-Path $raiz 'storage\framework\sessions') (Join-Path $raiz 'storage\framework\views') `
        (Join-Path $raiz 'storage\framework\testing') (Join-Path $raiz 'docs\referencia') `
    /XF .env .env.backup .env.production hot *.sqlite *.sqlite-journal *.zip .phpunit.result.cache `
        fonts-manifest.dev.json CLAUDE.md AGENTS.md | Out-Null
if ($LASTEXITCODE -ge 8) { throw "robocopy falló ($LASTEXITCODE)" }

# Carpetas que Laravel necesita aunque estén vacías
foreach ($d in 'storage\logs', 'storage\framework\cache\data', 'storage\framework\sessions', 'storage\framework\views', 'bootstrap\cache') {
    New-Item -ItemType Directory -Force (Join-Path $staging $d) | Out-Null
}
Get-ChildItem (Join-Path $staging 'bootstrap\cache') -Filter *.php | Remove-Item -Force

Write-Host '3/4 Instalando dependencias de producción (composer --no-dev)...'
Push-Location $staging
composer install --no-dev --optimize-autoloader --no-interaction --no-progress
if ($LASTEXITCODE -ne 0) { throw 'Falló composer install' }
Pop-Location

Write-Host '4/4 Comprimiendo...'
if (Test-Path $zip) { Remove-Item $zip -Force }
php -r "
    `$origen = '$($staging -replace '\\','/')'; `$destino = '$($zip -replace '\\','/')';
    `$z = new ZipArchive(); `$z->open(`$destino, ZipArchive::CREATE);
    `$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(`$origen, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);
    foreach (`$it as `$f) { `$rel = str_replace('\\', '/', substr(`$f->getPathname(), strlen(`$origen) + 1));
        `$f->isDir() ? `$z->addEmptyDir(`$rel) : `$z->addFile(`$f->getPathname(), `$rel); }
    `$z->close();"
if ($LASTEXITCODE -ne 0) { throw 'Falló la compresión' }

$mb = [math]::Round((Get-Item $zip).Length / 1MB, 1)
Write-Host "Listo: $zip ($mb MB). Súbelo y sigue docs\DESPLIEGUE.md"
