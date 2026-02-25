<?php

namespace Tests\Feature;

use Tests\TestCase;

class VersionControllerTest extends TestCase
{
    private string $versionJsonPath;
    private string $versionsDir;

    protected function setUp(): void
    {
        parent::setUp();
        $this->versionJsonPath = base_path('version.json');
        $this->versionsDir = base_path('versions');

        // Create a test version.json
        file_put_contents($this->versionJsonPath, json_encode([
            ['version' => '1.0.0', 'path' => 'versions/1.0.0.json'],
            ['version' => '1.1.0', 'path' => 'versions/1.1.0.json'],
        ]));

        // Create versions directory and version files
        if (!is_dir($this->versionsDir)) {
            mkdir($this->versionsDir, 0755, true);
        }

        file_put_contents($this->versionsDir . '/1.0.0.json', json_encode([
            'version' => '1.0.0',
            'releaseDate' => '2024/01/01',
            'createdDate' => '2024/01/01',
            'authors' => null,
            'url' => null,
            'description' => ['Initial release'],
            'newFeatures' => null,
            'changedFeatures' => null,
            'deletedFeatures' => null,
            'notice' => null,
            'security' => null,
            'futurePlans' => null,
            'note' => null,
        ]));

        file_put_contents($this->versionsDir . '/1.1.0.json', json_encode([
            'version' => '1.1.0',
            'releaseDate' => '2024/06/01',
            'createdDate' => '2024/05/01',
            'authors' => [['name' => 'Test Author']],
            'url' => ['https://example.com'],
            'description' => ['Feature update'],
            'newFeatures' => ['New feature A'],
            'changedFeatures' => null,
            'deletedFeatures' => null,
            'notice' => null,
            'security' => null,
            'futurePlans' => null,
            'note' => null,
        ]));
    }

    protected function tearDown(): void
    {
        // Clean up test files
        if (file_exists($this->versionJsonPath)) {
            unlink($this->versionJsonPath);
        }
        if (file_exists($this->versionsDir . '/1.0.0.json')) {
            unlink($this->versionsDir . '/1.0.0.json');
        }
        if (file_exists($this->versionsDir . '/1.1.0.json')) {
            unlink($this->versionsDir . '/1.1.0.json');
        }
        if (is_dir($this->versionsDir)) {
            @rmdir($this->versionsDir);
        }
        parent::tearDown();
    }

    /**
     * @test
     * バージョン一覧 - 表示 - 正常
     */
    public function test_version_index_returns_inertia_response(): void
    {
        $response = $this->get(route('version.index'));
        $response->assertStatus(200);
    }

    /**
     * @test
     * バージョン詳細 - 表示 - 正常
     */
    public function test_version_show_returns_inertia_response(): void
    {
        $response = $this->get(route('version.show', ['version' => '1.0.0']));
        $response->assertStatus(200);
    }

    /**
     * @test
     * バージョン詳細 - 表示 - 異常（存在しないバージョン）
     */
    public function test_version_show_returns_404_for_unknown_version(): void
    {
        $response = $this->get(route('version.show', ['version' => '99.99.99']));
        $response->assertStatus(404);
    }
}
