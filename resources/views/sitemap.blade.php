<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>https://example.com/</loc>
    </url>
    <url>
        <loc>https://example.com/blog</loc>
    </url>
    <url>
        <loc>https://example.com/about-me</loc>
    </url>
    <url>
        <loc>https://example.com/contact</loc>
    </url>
    @foreach($posts as $post)
        <url>
            <loc>https://larablog.com/blog/{{ $post->slug }}</loc>
        </url>
    @endforeach
</urlset>