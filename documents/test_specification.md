# テスト仕様書

## フロントエンド

|テスト名|項目|系統|評価規準|テストファイル|
|-|-|-|-|-|
|バージョン一覧表示（編集）|表示|正常|編集一覧画面が表示され、バージョン一覧・詳細・編集ボタンが表示される|`resources/js/tests/Pages/Editor/Index.test.tsx`|
|バージョン一覧（編集）空表示|表示|正常|バージョンが0件でも画面が表示される|`resources/js/tests/Pages/Editor/Index.test.tsx`|
|バージョン一覧（編集）編集ボタン|表示|正常|各バージョンに編集ボタンが表示される|`resources/js/tests/Pages/Editor/Index.test.tsx`|
|バージョン一覧（編集）詳細ボタン|表示|正常|各バージョンに詳細ボタンが表示される|`resources/js/tests/Pages/Editor/Index.test.tsx`|
|バージョン一覧（編集）新規追加ボタン|表示|正常|新規追加ボタンが表示される|`resources/js/tests/Pages/Editor/Index.test.tsx`|
|バージョン一覧（編集）バージョン履歴リンク|表示|正常|バージョン履歴リンクが表示される|`resources/js/tests/Pages/Editor/Index.test.tsx`|
|バージョン新規作成フォーム表示|表示|正常|新規追加フォームが表示される|`resources/js/tests/Pages/Editor/Edit.test.tsx`|
|バージョン新規作成 バージョンタイプ選択|表示|正常|メジャー・マイナー・パッチの選択肢が表示される|`resources/js/tests/Pages/Editor/Edit.test.tsx`|
|バージョン新規作成 日付入力欄|表示|正常|作成日・リリース日の入力欄が表示される|`resources/js/tests/Pages/Editor/Edit.test.tsx`|
|バージョン新規作成 登録ボタン|表示|正常|登録ボタンが表示される|`resources/js/tests/Pages/Editor/Edit.test.tsx`|
|バージョン新規作成 戻るリンク|表示|正常|戻るリンクが表示される|`resources/js/tests/Pages/Editor/Edit.test.tsx`|
|バージョン編集フォーム表示|表示|正常|既存バージョンの編集フォームが表示される|`resources/js/tests/Pages/Editor/Edit.test.tsx`|
|バージョン編集 バージョンタイプ非表示|表示|正常|既存バージョン編集時にバージョンタイプ選択肢が表示されない|`resources/js/tests/Pages/Editor/Edit.test.tsx`|
|バージョン編集 日付入力欄|表示|正常|作成日・リリース日の入力欄が表示される|`resources/js/tests/Pages/Editor/Edit.test.tsx`|
|バージョン編集 登録ボタン|表示|正常|登録ボタンが表示される|`resources/js/tests/Pages/Editor/Edit.test.tsx`|
|バージョン一覧表示（公開）|表示|正常|バージョン履歴画面が表示される|`resources/js/tests/Pages/Version/Index.test.tsx`|
|バージョン一覧（公開）空表示|表示|正常|バージョンが0件でも画面が表示される|`resources/js/tests/Pages/Version/Index.test.tsx`|
|バージョン一覧（公開）リンク|表示|正常|各バージョンがリンクになっている|`resources/js/tests/Pages/Version/Index.test.tsx`|
|バージョン詳細表示|表示|正常|バージョン詳細情報が表示される|`resources/js/tests/Pages/Version/Show.test.tsx`|
|バージョン詳細 日付表示|表示|正常|作成日・リリース日が表示される|`resources/js/tests/Pages/Version/Show.test.tsx`|
|バージョン詳細 執筆者表示|表示|正常|執筆者が表示される|`resources/js/tests/Pages/Version/Show.test.tsx`|
|バージョン詳細 セクション表示|表示|正常|説明・新機能・変更機能等の各セクションが表示される|`resources/js/tests/Pages/Version/Show.test.tsx`|
|バージョン詳細 最小表示|表示|正常|nullフィールドがあっても正常に表示される|`resources/js/tests/Pages/Version/Show.test.tsx`|
|バージョン詳細 URLリンク|表示|正常|URLがリンクとして表示される|`resources/js/tests/Pages/Version/Show.test.tsx`|

## バックエンド

|テスト名|項目|系統|評価規準|テストファイル|
|-|-|-|-|-|
|バージョン一覧|表示|正常|バージョン一覧がレスポンスで返される（200，OK）|`Tests\Feature\VersionControllerTest::test_version_index_returns_inertia_response`|
|バージョン詳細|表示|正常|バージョン詳細がレスポンスで返される（200，OK）|`Tests\Feature\VersionControllerTest::test_version_show_returns_inertia_response`|
|バージョン詳細（存在しない）|表示|異常|存在しないバージョンは404が返される|`Tests\Feature\VersionControllerTest::test_version_show_returns_404_for_unknown_version`|
|エディター一覧|表示|正常|エディター一覧がレスポンスで返される（200，OK）|`Tests\Feature\EditorControllerTest::test_editor_index_returns_inertia_response`|
|エディター新規作成フォーム|表示|正常|新規作成フォームがレスポンスで返される（200，OK）|`Tests\Feature\EditorControllerTest::test_editor_create_returns_inertia_response`|
|エディター編集フォーム|表示|正常|編集フォームがレスポンスで返される（200，OK）|`Tests\Feature\EditorControllerTest::test_editor_edit_returns_inertia_response`|
|エディター編集フォーム（存在しない）|表示|異常|存在しないバージョンは404が返される|`Tests\Feature\EditorControllerTest::test_editor_edit_returns_404_for_unknown_version`|
|エディター新規作成|登録|正常|新バージョンが作成されリダイレクトされる（302，Redirect）|`Tests\Feature\EditorControllerTest::test_editor_store_creates_new_version`|
|エディター更新|更新|正常|バージョン情報が更新されリダイレクトされる（302，Redirect）|`Tests\Feature\EditorControllerTest::test_editor_update_modifies_version`|
|エディター詳細|表示|正常|エディター詳細がレスポンスで返される（200，OK）|`Tests\Feature\EditorControllerTest::test_editor_show_returns_inertia_response`|
|エディター詳細（存在しない）|表示|異常|存在しないバージョンは404が返される|`Tests\Feature\EditorControllerTest::test_editor_show_returns_404_for_unknown_version`|
|ミドルウェア ローカル環境|認可|正常|ローカル環境ではアクセスが許可される|`Tests\Feature\VersioningEditorMiddlewareTest::test_allows_access_in_local_environment`|
|ミドルウェア 非ローカル・認証なし|認可|異常|非ローカル環境で未認証はアクセスが拒否される（401）|`Tests\Feature\VersioningEditorMiddlewareTest::test_rejects_unauthenticated_user_in_non_local`|
|ミドルウェア 許可ID|認可|正常|許可されたユーザーIDでアクセスできる|`Tests\Feature\VersioningEditorMiddlewareTest::test_allows_user_with_permitted_id`|
|ミドルウェア 許可メール|認可|正常|許可されたメールアドレスでアクセスできる|`Tests\Feature\VersioningEditorMiddlewareTest::test_allows_user_with_permitted_email`|
|ミドルウェア 権限なし|認可|異常|許可されていないユーザーはアクセスが拒否される（401）|`Tests\Feature\VersioningEditorMiddlewareTest::test_rejects_user_without_permission`|
