<?php

namespace Signifly\Shopify\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Signifly\Shopify\Factory;
use Signifly\Shopify\REST\Cursor;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\REST\Resources\ArticleResource;
use Signifly\Shopify\REST\Resources\AssetResource;
use Signifly\Shopify\REST\Resources\BlogResource;
use Signifly\Shopify\REST\Resources\PageResource;
use Signifly\Shopify\Shopify;

class ManagesOnlineStoreTest extends TestCase
{
    private Shopify $shopify;

    public function setUp(): void
    {
        parent::setUp();

        $this->shopify = Factory::fromConfig();
    }

    /** @test **/
    public function it_creates_a_redirect()
    {
        Http::fake([
            '*' => Http::response($this->fixture('redirects.create')),
        ]);

        $resource = $this->shopify->createRedirect('/ipod', '/pages/itunes');

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/redirects.json', $request->url());
            $this->assertEquals(['redirect' => ['path' => '/ipod', 'target' => '/pages/itunes']], $request->data());
            $this->assertEquals('POST', $request->method());

            return true;
        });
        $this->assertInstanceOf(ApiResource::class, $resource);
    }

    /** @test **/
    public function it_counts_redirects()
    {
        Http::fake([
            '*' => Http::response(['count' => 42]),
        ]);

        $count = $this->shopify->getRedirectsCount();

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/redirects/count.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertEquals(42, $count);
    }

    /** @test **/
    public function it_gets_redirects()
    {
        Http::fake([
            '*' => Http::response($this->fixture('redirects.all')),
        ]);

        $resources = $this->shopify->getRedirects();

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/redirects.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });

        $this->assertInstanceOf(Collection::class, $resources);
        $this->assertInstanceOf(ApiResource::class, $resources->first());
        $this->assertCount(3, $resources);
    }

    /** @test **/
    public function it_finds_a_redirect()
    {
        Http::fake([
            '*' => Http::response($this->fixture('redirects.show')),
        ]);

        $resource = $this->shopify->getRedirect($id = 1234);

        Http::assertSent(function (Request $request) use ($id) {
            $this->assertEquals($this->shopify->getBaseUrl().'/redirects/'.$id.'.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertInstanceOf(ApiResource::class, $resource);
    }

    /** @test **/
    public function it_updates_a_redirect()
    {
        Http::fake([
            '*' => Http::response($this->fixture('redirects.show')),
        ]);

        $id = 1234;

        $resource = $this->shopify->updateRedirect($id, $payload = [
            'path' => '/foo',
            'target' => '/pages/bar',
        ]);

        Http::assertSent(function (Request $request) use ($id, $payload) {
            $this->assertEquals($this->shopify->getBaseUrl().'/redirects/'.$id.'.json', $request->url());
            $this->assertEquals(['redirect' => $payload], $request->data());
            $this->assertEquals('PUT', $request->method());

            return true;
        });
        $this->assertInstanceOf(ApiResource::class, $resource);
    }

    /** @test * */
    public function it_deletes_a_redirect()
    {
        Http::fake([
            '*' => Http::response(),
        ]);

        $id = 1234;

        $this->shopify->deleteRedirect($id);

        Http::assertSent(function (Request $request) use ($id) {
            $this->assertEquals($this->shopify->getBaseUrl().'/redirects/'.$id.'.json', $request->url());
            $this->assertEquals('DELETE', $request->method());

            return true;
        });
    }

    /** @test **/
    public function it_paginates_redirects()
    {
        Http::fakeSequence()
            ->push(['count' => 6], 200)
            ->push($this->fixture('redirects.all'), 200, ['Link' => '<'.$this->shopify->getBaseUrl().'/redirects.json?page_info=1234&limit=2>; rel=next'])
            ->push($this->fixture('redirects.all'), 200);

        $count = $this->shopify->getRedirectsCount();
        $pages = $this->shopify->paginateRedirects(['limit' => 2]);

        $results = collect();

        foreach ($pages as $page) {
            $results = $results->merge($page);
        }

        $this->assertInstanceOf(Cursor::class, $pages);
        $this->assertEquals($count, $results->count());

        Http::assertSequencesAreEmpty();
    }

    public function it_creates_a_blog()
    {
        Http::fake([
            '*' => Http::response($this->fixture('blogs.create')),
        ]);

        $resource = $this->shopify->createBlog($payload = [
            'title' => 'Apple main blog',
        ]);

        Http::assertSent(function (Request $request) use ($payload) {
            $this->assertEquals($this->shopify->getBaseUrl().'/blogs.json', $request->url());
            $this->assertEquals(['blog' => $payload], $request->data());
            $this->assertEquals('POST', $request->method());

            return true;
        });
        $this->assertInstanceOf(BlogResource::class, $resource);
    }

    /** @test **/
    public function it_counts_blogs()
    {
        Http::fake([
            '*' => Http::response(['count' => 42]),
        ]);

        $count = $this->shopify->getBlogsCount();

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/blogs/count.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertEquals(42, $count);
    }

    /** @test **/
    public function it_gets_blogs()
    {
        Http::fake([
            '*' => Http::response($this->fixture('blogs.all')),
        ]);

        $resources = $this->shopify->getBlogs();

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/blogs.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertInstanceOf(Collection::class, $resources);
        $this->assertInstanceOf(BlogResource::class, $resources->first());
        $this->assertCount(2, $resources);
    }

    /** @test **/
    public function it_finds_a_blog()
    {
        Http::fake([
            '*' => Http::response($this->fixture('blogs.show')),
        ]);

        $resource = $this->shopify->getBlog($id = 1234);

        Http::assertSent(function (Request $request) use ($id) {
            $this->assertEquals($this->shopify->getBaseUrl().'/blogs/'.$id.'.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertInstanceOf(BlogResource::class, $resource);
    }

    /** @test **/
    public function it_updates_a_blog()
    {
        Http::fake([
            '*' => Http::response($this->fixture('blogs.show')),
        ]);

        $id = 1234;

        $resource = $this->shopify->updateBlog($id, $payload = [
            'title' => 'IPod Updates',
        ]);

        Http::assertSent(function (Request $request) use ($id, $payload) {
            $this->assertEquals($this->shopify->getBaseUrl().'/blogs/'.$id.'.json', $request->url());
            $this->assertEquals(['blog' => $payload], $request->data());
            $this->assertEquals('PUT', $request->method());

            return true;
        });
        $this->assertInstanceOf(BlogResource::class, $resource);
    }

    /** @test **/
    public function it_deletes_a_blog()
    {
        Http::fake([
            '*' => Http::response(),
        ]);

        $id = 1234;

        $this->shopify->deleteBlog($id);

        Http::assertSent(function (Request $request) use ($id) {
            $this->assertEquals($this->shopify->getBaseUrl().'/blogs/'.$id.'.json', $request->url());
            $this->assertEquals('DELETE', $request->method());

            return true;
        });
    }

    /** @test **/
    public function it_paginates_blogs()
    {
        Http::fakeSequence()
            ->push(['count' => 4], 200)
            ->push($this->fixture('blogs.all'), 200, ['Link' => '<'.$this->shopify->getBaseUrl().'/blogs.json?page_info=1234&limit=2>; rel=next'])
            ->push($this->fixture('blogs.all'), 200);

        $count = $this->shopify->getBlogsCount();
        $pages = $this->shopify->paginateBlogs(['limit' => 2]);

        $results = collect();

        foreach ($pages as $page) {
            $results = $results->merge($page);
        }

        $this->assertInstanceOf(Cursor::class, $pages);
        $this->assertEquals($count, $results->count());

        Http::assertSequencesAreEmpty();
    }

    /** @test */
    public function it_creates_a_page()
    {
        Http::fake([
            '*' => Http::response($this->fixture('pages.show')),
        ]);

        $resource = $this->shopify->createPage($payload = [
            'title' => 'Apple main page',
        ]);

        Http::assertSent(function (Request $request) use ($payload) {
            $this->assertEquals($this->shopify->getBaseUrl().'/pages.json', $request->url());
            $this->assertEquals(['page' => $payload], $request->data());
            $this->assertEquals('POST', $request->method());

            return true;
        });
        $this->assertInstanceOf(PageResource::class, $resource);
    }

    /** @test **/
    public function it_counts_pages()
    {
        Http::fake([
            '*' => Http::response(['count' => 42]),
        ]);

        $count = $this->shopify->getPagesCount();

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/pages/count.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertEquals(42, $count);
    }

    /** @test **/
    public function it_gets_pages()
    {
        Http::fake([
            '*' => Http::response($this->fixture('pages.all')),
        ]);

        $resources = $this->shopify->getPages();

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/pages.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertInstanceOf(Collection::class, $resources);
        $this->assertInstanceOf(PageResource::class, $resources->first());
        $this->assertCount(4, $resources);
    }

    /** @test **/
    public function it_finds_a_page()
    {
        Http::fake([
            '*' => Http::response($this->fixture('pages.show')),
        ]);

        $resource = $this->shopify->getPage($id = 1234);

        Http::assertSent(function (Request $request) use ($id) {
            $this->assertEquals($this->shopify->getBaseUrl().'/pages/'.$id.'.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertInstanceOf(PageResource::class, $resource);
    }

    /** @test **/
    public function it_updates_a_page()
    {
        Http::fake([
            '*' => Http::response($this->fixture('pages.show')),
        ]);

        $id = 1234;

        $resource = $this->shopify->updatePage($id, $payload = [
            'title' => 'IPod Updates',
        ]);

        Http::assertSent(function (Request $request) use ($id, $payload) {
            $this->assertEquals($this->shopify->getBaseUrl().'/pages/'.$id.'.json', $request->url());
            $this->assertEquals(['page' => $payload], $request->data());
            $this->assertEquals('PUT', $request->method());

            return true;
        });
        $this->assertInstanceOf(PageResource::class, $resource);
    }

    /** @test **/
    public function it_deletes_a_page()
    {
        Http::fake([
            '*' => Http::response(),
        ]);

        $id = 1234;

        $this->shopify->deletePage($id);

        Http::assertSent(function (Request $request) use ($id) {
            $this->assertEquals($this->shopify->getBaseUrl().'/pages/'.$id.'.json', $request->url());
            $this->assertEquals('DELETE', $request->method());

            return true;
        });
    }

    /** @test **/
    public function it_paginates_pages()
    {
        Http::fakeSequence()
            ->push(['count' => 8], 200)
            ->push($this->fixture('pages.all'), 200, ['Link' => '<'.$this->shopify->getBaseUrl().'/pages.json?page_info=1234&limit=2>; rel=next'])
            ->push($this->fixture('pages.all'), 200);

        $count = $this->shopify->getPagesCount();
        $pages = $this->shopify->paginatePages(['limit' => 2]);

        $results = collect();

        foreach ($pages as $page) {
            $results = $results->merge($page);
        }

        $this->assertInstanceOf(Cursor::class, $pages);
        $this->assertEquals($count, $results->count());

        Http::assertSequencesAreEmpty();
    }

    /** @test */
    public function it_creates_an_article()
    {
        Http::fake([
            '*' => Http::response($this->fixture('articles.show')),
        ]);

        $resource = $this->shopify->createArticle($payload = [
            'title' => 'My new Article title',
            'author' => 'John Smith',
        ]);

        Http::assertSent(function (Request $request) use ($payload) {
            $this->assertEquals($this->shopify->getBaseUrl().'/articles.json', $request->url());
            $this->assertEquals(['article' => $payload], $request->data());
            $this->assertEquals('POST', $request->method());

            return true;
        });
        $this->assertInstanceOf(ArticleResource::class, $resource);
    }

    /** @test **/
    public function it_counts_articles()
    {
        Http::fake([
            '*' => Http::response(['count' => 42]),
        ]);

        $count = $this->shopify->getArticlesCount();

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/articles/count.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertEquals(42, $count);
    }

    /** @test **/
    public function it_gets_articles()
    {
        Http::fake([
            '*' => Http::response($this->fixture('articles.all')),
        ]);

        $resources = $this->shopify->getArticles();

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/articles.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertInstanceOf(Collection::class, $resources);
        $this->assertInstanceOf(ArticleResource::class, $resources->first());
        $this->assertCount(4, $resources);
    }

    /** @test */
    public function it_gets_article_authors()
    {
        Http::fake([
            '*' => Http::response(['authors' => ['Foo', 'Bar']]),
        ]);

        $authors = $this->shopify->getArticleAuthors();

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/articles/authors.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });

        $this->assertEquals(['Foo', 'Bar'], $authors);
    }

    /** @test */
    public function it_gets_article_tags()
    {
        Http::fake([
            '*' => Http::response(['tags' => ['Announcement', 'New']]),
        ]);

        $tags = $this->shopify->getArticleTags();

        Http::assertSent(function (Request $request) {
            $this->assertEquals($this->shopify->getBaseUrl().'/articles/tags.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });

        $this->assertEquals(['Announcement', 'New'], $tags);
    }

    /** @test **/
    public function it_finds_an_article()
    {
        Http::fake([
            '*' => Http::response($this->fixture('articles.show')),
        ]);

        $resource = $this->shopify->getArticle($id = 1234);

        Http::assertSent(function (Request $request) use ($id) {
            $this->assertEquals($this->shopify->getBaseUrl().'/articles/'.$id.'.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });
        $this->assertInstanceOf(ArticleResource::class, $resource);
    }

    /** @test **/
    public function it_updates_an_article()
    {
        Http::fake([
            '*' => Http::response($this->fixture('articles.show')),
        ]);

        $id = 1234;

        $resource = $this->shopify->updateArticle($id, $payload = [
            'title' => 'Some new title',
        ]);

        Http::assertSent(function (Request $request) use ($id, $payload) {
            $this->assertEquals($this->shopify->getBaseUrl().'/articles/'.$id.'.json', $request->url());
            $this->assertEquals(['article' => $payload], $request->data());
            $this->assertEquals('PUT', $request->method());

            return true;
        });
        $this->assertInstanceOf(ArticleResource::class, $resource);
    }

    /** @test **/
    public function it_deletes_an_article()
    {
        Http::fake([
            '*' => Http::response(),
        ]);

        $id = 1234;

        $this->shopify->deleteArticle($id);

        Http::assertSent(function (Request $request) use ($id) {
            $this->assertEquals($this->shopify->getBaseUrl().'/articles/'.$id.'.json', $request->url());
            $this->assertEquals('DELETE', $request->method());

            return true;
        });
    }

    /** @test **/
    public function it_paginates_articles()
    {
        Http::fakeSequence()
            ->push(['count' => 8], 200)
            ->push($this->fixture('articles.all'), 200, ['Link' => '<'.$this->shopify->getBaseUrl().'/articles.json?page_info=1234&limit=2>; rel=next'])
            ->push($this->fixture('articles.all'), 200);

        $count = $this->shopify->getArticlesCount();
        $pages = $this->shopify->paginateArticles(['limit' => 2]);

        $results = collect();

        foreach ($pages as $page) {
            $results = $results->merge($page);
        }

        $this->assertInstanceOf(Cursor::class, $pages);
        $this->assertEquals($count, $results->count());

        Http::assertSequencesAreEmpty();
    }

    /** @test **/
    public function it_gets_assets()
    {
        Http::fake([
            '*' => Http::response($this->fixture('assets.all')),
        ]);

        $themeId = 'test-theme';

        $resources = $this->shopify->getAssets($themeId);

        Http::assertSent(function (Request $request) use ($themeId) {
            $this->assertEquals($this->shopify->getBaseUrl().'/themes/'.$themeId.'/assets.json', $request->url());
            $this->assertEquals('GET', $request->method());

            return true;
        });

        $this->assertInstanceOf(Collection::class, $resources);

        $this->assertInstanceOf(AssetResource::class, $resources->first());

        $this->assertCount(27, $resources);
    }

    /** @test **/
    public function it_finds_an_asset()
    {
        Http::fake([
            '*' => Http::response($this->fixture('assets.show')),
        ]);

        $themeId = 'test-theme';
        $assetKey = 'assets/bg-body.gif';

        $resource = $this->shopify->getAsset($themeId, $assetKey);

        Http::assertSent(function (Request $request) use ($themeId, $assetKey) {
            $this->assertEquals($this->shopify->getBaseUrl().'/themes/'.$themeId.'/assets.json?asset[key]='.$assetKey, urldecode($request->url()));
            $this->assertEquals('GET', $request->method());

            return true;
        });

        $this->assertInstanceOf(AssetResource::class, $resource);
    }

    /** @test **/
    public function it_updates_an_asset()
    {
        Http::fake([
            '*' => Http::response($this->fixture('assets.show')),
        ]);

        $themeId = 'test-theme';
        $assetKey = 'assets/bg-body.gif';

        $resource = $this->shopify->updateAsset($themeId, $payload = [
            'key' => $assetKey,
            'value' => "<img src='backsoon-postit.png'><p>We are busy updating the store for you and will be back within the hour.</p>",
        ]);

        Http::assertSent(function (Request $request) use ($themeId, $payload) {
            $this->assertEquals($this->shopify->getBaseUrl().'/themes/'.$themeId.'/assets.json', $request->url());
            $this->assertEquals($payload, $request->data());
            $this->assertEquals('PUT', $request->method());

            return true;
        });
        $this->assertInstanceOf(AssetResource::class, $resource);
    }

    /** @test **/
    public function it_deletes_an_asset()
    {
        Http::fake([
            '*' => Http::response(),
        ]);

        $themeId = 'theme';
        $assetKey = 'assets/bg-body.gif';

        $this->shopify->deleteAsset($themeId, $assetKey);

        Http::assertSent(function (Request $request) use ($themeId, $assetKey) {
            $this->assertEquals($this->shopify->getBaseUrl().'/themes/'.$themeId.'/assets.json?asset[key]='.$assetKey, urldecode($request->url()));
            $this->assertEquals('DELETE', $request->method());

            return true;
        });
    }
}
