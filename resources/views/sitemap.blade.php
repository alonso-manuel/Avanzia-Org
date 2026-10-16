{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach ($paginas as $pagina)
    <url>
        <loc>{{ $pagina['url'] }}</loc>
@if ($pagina['lastmod'])
        <lastmod>{{ \Illuminate\Support\Carbon::parse($pagina['lastmod'])->toAtomString() }}</lastmod>
@endif
    </url>
@endforeach
</urlset>
