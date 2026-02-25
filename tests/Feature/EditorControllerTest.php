<?php

namespace Tests\Feature;

use Tests\TestCase;

class EditorControllerTest extends TestCase
{
    private string $versionJsonPath;
    private string $versionsDir;

    protected function setUp(): void
    {
        parent::setUp();
        // Disable all middleware for controller tests (CSRF etc. tested separately)
        $this->withoutMiddleware();
        $this->versionJsonPath = base_path('version.json');
        $this->versionsDir = base_path('versions');

        // Create a test version.json
        file_put_contents($this->versionJsonPath, json_encode([
            ['version' => '1.0.0', 'path' => 'versions/1.0.0.json'],
        ]));

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
    }

    protected function tearDown(): void
    {
        if (file_exists($this->versionJsonPath)) {
            unlink($this->versionJsonPath);
        }
        if (file_exists($this->versionsDir . '/1.0.0.json')) {
            unlink($this->versionsDir . '/1.0.0.json');
        }
        // Remove any version files created by tests
        foreach (['1.0.1.json', '2.0.0.json', '1.1.0.json'] as $file) {
            if (file_exists($this->versionsDir . '/' . $file)) {
                unlink($this->versionsDir . '/' . $file);
            }
        }
        if (is_dir($this->versionsDir)) {
            @rmdir($this->versionsDir);
        }
        parent::tearDown();
    }

    /**
     * @test
     * バージョン一覧（編集）- 表示 - 正常
     */
    public function test_editor_index_returns_inertia_response(): void
    {
        $response = $this->get(route('version.editor.index'));
        $response->assertStatus(200);
    }

    /**
     * @test
     * バージョン新規作成フォーム - 表示 - 正常
     */
    public function test_editor_create_returns_inertia_response(): void
    {
        $response = $this->get(route('version.editor.create'));
        $response->assertStatus(200);
    }

    /**
     * @test
     * バージョン編集フォーム - 表示 - 正常
     */
    public function test_editor_edit_returns_inertia_response(): void
    {
        $response = $this->get(route('version.editor.edit', ['editor' => '1.0.0']));
        $response->assertStatus(200);
    }

    /**
     * @test
     * バージョン編集フォーム - 表示 - 異常（存在しないバージョン）
     */
    public function test_editor_edit_returns_404_for_unknown_version(): void
    {
        $response = $this->get(route('version.editor.edit', ['editor' => '99.99.99']));
        $response->assertStatus(404);
    }

    /**
     * @test
     * バージョン新規作成 - 登録 - 正常
     */
    public function test_editor_store_creates_new_version(): void
    {
        $response = $this->post(route('version.editor.store'), [
            'version_type' => 'patch',
            'createdDate' => '2024-07-01',
            'releaseDate' => '2024-07-01',
            'description' => ['New patch release'],
        ]);
        $response->assertRedirect();

        // Verify the new version was created
        $versions = json_decode(file_get_contents($this->versionJsonPath), true);
        $this->assertCount(2, $versions);
    }

    /**
     * @test
     * バージョン更新 - 更新 - 正常
     */
    public function test_editor_update_modifies_version(): void
    {
        $response = $this->put(route('version.editor.update', ['editor' => '1.0.0']), [
            'createdDate' => '2024-01-01',
            'releaseDate' => '2024-01-15',
            'description' => ['Updated description'],
        ]);
        $response->assertRedirect();

        // Verify the version was updated
        $versionData = json_decode(file_get_contents($this->versionsDir . '/1.0.0.json'), true);
        $this->assertEquals('Updated description', $versionData['description'][0]);
    }

    /**
     * @test
     * バージョン詳細（編集）- 表示 - 正常
     */
    public function test_editor_show_returns_inertia_response(): void
    {
        $response = $this->get(route('version.editor.show', ['editor' => '1.0.0']));
        $response->assertStatus(200);
    }

    /**
     * @test
     * バージョン詳細（編集）- 表示 - 異常（存在しないバージョン）
     */
    public function test_editor_show_returns_404_for_unknown_version(): void
    {
        $response = $this->get(route('version.editor.show', ['editor' => '99.99.99']));
        $response->assertStatus(404);
    }
}
