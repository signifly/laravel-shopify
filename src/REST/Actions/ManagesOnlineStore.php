<?php

namespace Signifly\Shopify\REST\Actions;

use Illuminate\Support\Collection;
use Signifly\Shopify\REST\Cursor;
use Signifly\Shopify\REST\Resources\ApiResource;
use Signifly\Shopify\REST\Resources\BlogResource;
use Signifly\Shopify\REST\Resources\PageResource;
use Signifly\Shopify\Shopify;

/** @mixin Shopify */
trait ManagesOnlineStore
{
    public function createRedirect(string $path, string $target): ApiResource
    {
        return $this->createResource('redirects', [
            'path' => $path,
            'target' => $target,
        ]);
    }

    public function getRedirectsCount(array $params = []): int
    {
        return $this->getResourceCount('redirects', $params);
    }

    public function paginateRedirects(array $params = []): Cursor
    {
        return $this->cursor($this->getRedirects($params));
    }

    public function getRedirects(array $params = []): Collection
    {
        return $this->getResources('redirects', $params);
    }

    public function getRedirect($redirectId): ApiResource
    {
        return $this->getResource('redirects', $redirectId);
    }

    public function updateRedirect($redirectId, $data): ApiResource
    {
        return $this->updateResource('redirects', $redirectId, $data);
    }

    public function deleteRedirect($redirectId): void
    {
        $this->deleteResource('redirects', $redirectId);
    }

    public function createBlog(array $data): BlogResource
    {
        return $this->createResource('blogs', $data);
    }

    public function getBlogsCount(array $params = []): int
    {
        return $this->getResourceCount('blogs', $params);
    }

    public function paginateBlogs(array $params = []): Cursor
    {
        return $this->cursor($this->getBlogs($params));
    }

    public function getBlogs(array $params = []): Collection
    {
        return $this->getResources('blogs', $params);
    }

    public function getBlog($blogId): BlogResource
    {
        return $this->getResource('blogs', $blogId);
    }

    public function updateBlog($blogId, $data): BlogResource
    {
        return $this->updateResource('blogs', $blogId, $data);
    }

    public function deleteBlog($blogId): void
    {
        $this->deleteResource('blogs', $blogId);
    }

    public function createPage(array $data): PageResource
    {
        return $this->createResource('pages', $data);
    }

    public function getPagesCount(array $params = []): int
    {
        return $this->getResourceCount('pages', $params);
    }

    public function paginatePages(array $params = []): Cursor
    {
        return $this->cursor($this->getPages($params));
    }

    public function getPages(array $params = []): Collection
    {
        return $this->getResources('pages', $params);
    }

    public function getPage($pageId): PageResource
    {
        return $this->getResource('pages', $pageId);
    }

    public function updatePage($pageId, $data): PageResource
    {
        return $this->updateResource('pages', $pageId, $data);
    }

    public function deletePage($pageId): void
    {
        $this->deleteResource('pages', $pageId);
    }
}
