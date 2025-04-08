# DDD ベースのログイン & ブログ投稿システム

このプロジェクトは、**ドメイン駆動設計 (DDD)** を採用した **ログインシステムとブログ投稿システム** を実装したものです。  
また、ユースケースを中心としたテストも作成しています。

## 📌 **主な機能**

-   **ユーザー認証**

    -   新規ユーザー登録
    -   ログイン / ログアウト
    -   認証済みユーザーのみが操作可能

-   **ブログ投稿システム**
    -   記事の投稿
    -   記事の削除
    -   記事の一覧・詳細表示
    -   **投稿の所有者のみが削除可能**

## 🏛 **アーキテクチャ**

本プロジェクトでは **ドメイン駆動設計 (DDD: Domain-Driven Design)** を採用。

app  
├─ Application  
│ ├─ Post  
│ │ ├─ DTO  
│ │ │ └─ PostDTO.php  
│ │ └─ UseCase  
│ │ ├─ CreatePostUseCase.php  
│ │ ├─ DeletePostUseCase.php  
│ │ ├─ PostDetailUseCase.php  
│ │ └─ PostListUseCase.php  
│ └─ User  
│ ├─ DTO  
│ │ └─ UserDTO.php  
│ └─ UseCase  
│ ├─ LoginUserUseCase.php  
│ ├─ LogoutUserUseCase.php  
│ └─ RegisterUserUseCase.php  
├─ Domain  
│ ├─ Post  
│ │ ├─ Entity  
│ │ │ └─ Post.php  
│ │ ├─ Exceptions  
│ │ └─ Repository  
│ │ └─ PostRepositoryInterface.php  
│ └─ User  
│ ├─ Entity  
│ │ └─ User.php  
│ ├─ Exceptions  
│ │ ├─ InvalidEmailException.php  
│ │ └─ UserNotFoundException.php  
│ ├─ Repository  
│ │ └─ UserRepositoryInterface.php  
│ └─ ValueObject  
│ └─ Email.php  
├─ Exceptions  
│ ├─ Handler.php  
│ └─ PostSaveException.php  
├─ Http  
│ ├─ Controllers  
│ │ ├─ Controller.php  
│ │ ├─ PostController.php  
│ │ └─ UserController.php  
│ ├─ Requests  
│ │ ├─ LoginRequest.php  
│ │ └─ PostRequest.php  
│ └─ Kernel.php  
├─ Infrastructure  
│ └─ Repository  
│ ├─ PostRepositoryImpl.php  
│ └─ UserRepositoryImpl.php  
├─ Models  
│ ├─ Post.php  
│ └─ User.php  
└─ Providers  
 ├─ AppServiceProvider.php  
 ├─ AuthServiceProvider.php  
 ├─ BroadcastServiceProvider.php  
 ├─ EventServiceProvider.php  
 └─ RouteServiceProvider.php

## ✅ **テスト**

本プロジェクトでは、**ユースケースを中心にテスト** を作成しています。

tests  
├─ Feature  
│ ├─ ExampleTest.php  
│ └─ UserControllerTest.php  
├─ Unit  
│ ├─ Application  
│ │ ├─ Post  
│ │ │ └─ UseCase  
│ │ │ ├─ CreatePostUseCaseTest.php  
│ │ │ ├─ DeletePostUseCaseTest.php  
│ │ │ ├─ PostDetailUseCaseTest.php  
│ │ │ └─ PostListUseCaseTest.php  
│ │ └─ User  
│ │ └─ UseCase  
│ │ ├─ LoginLogoutUserUseCaseTest.php  
│ │ └─ RegisterUserUseCaseTest.php  
│ ├─ Domain  
│ │ └─ User  
│ │ └─ Repository  
│ │ └─ MockEloquentUser.php  
│ └─ ExampleTest.php  
├─ CreatesApplication.php  
└─ TestCase.php

# 📄 要件定義書

## プロジェクト名

ドメイン駆動設計 (DDD) によるログイン認証付きブログシステムサンプル

---

### 1. システム概要

本システムは、ドメイン駆動設計（DDD）を採用し、ユーザーの認証とブログ投稿機能を提供するサンプル Web アプリケーションである。ビジネスロジックとユースケースを明確に分離し、保守性・拡張性に優れた構成を実現することを目的とする。

### 2. 機能要件

#### 2.1 認証機能（User）

-   ユーザー登録（新規登録）
-   ユーザーログイン
-   ユーザーログアウト

#### 2.2 投稿機能（Post）

-   投稿作成
-   投稿一覧表示
-   投稿詳細表示
-   投稿削除

### 3. 非機能要件

-   **構造の明確化**：アプリケーション層とドメイン層を明確に分離し、責務の境界をはっきりさせる。
-   **拡張性**：UseCase 単位の拡張が容易であり、将来的な機能追加に対応しやすい構造。
-   **テスト容易性**：ドメインロジックが独立しており、ユニットテストの作成が容易。
-   **再利用性**：DTO や ValueObject などの再利用可能なパーツを整備。

### 4. システム構成（構造）

#### 4.1 Application 層（ユースケースの実装）

-   **UseCase**：各機能のユースケースを担当  
    例）CreatePostUseCase, LoginUserUseCase など
-   **DTO**：外部とのデータ受け渡しを担う

#### 4.2 Domain 層（ドメインモデルの表現）

-   **Entity**：永続化対象のドメインモデル（例：Post, User）
-   **Repository Interface**：永続化の抽象定義
-   **ValueObject**：不変の値（例：Email）このシステムにおいては未使用
-   **Exceptions**：ドメイン特有のエラーハンドリング

#### 4.3 Infrastructure 層（技術的実装）

-   **RepositoryImpl**：RepositoryInterface の具体的実装（Eloquent 等）

#### 4.4 Http 層（プレゼンテーション層）

-   **Controllers**：リクエストを受け取り、UseCase を呼び出す
-   **Requests**：バリデーションの定義

#### 4.5 その他

-   **Models**：Eloquent ベースの ORM モデル
-   **Providers**：サービスプロバイダー定義
-   **Exceptions**：アプリケーション共通の例外定義

### 5. 想定ユーザー

-   開発者（DDD の学習目的）
-   アーキテクチャ設計の参考にする技術者
-   Web アプリのプロトタイプ開発者

### 6. 課題

-   Laravel 標準の開発スタイルとの整合性の取り扱い（FormRequest、ServiceProvider などとの連携）
-   DDD の概念に不慣れな開発者にとって、コード全体の理解コストが上がる
-   小規模プロジェクトへの DDD 適用のコスト対効果

### 7. 課題解決

-   明確なレイヤー分離と命名規則の徹底により、DDD 初心者でも学習しやすい構造とする
-   必要最小限の構成で DDD を実現することで、理解と導入のハードルを下げる
-   Laravel の DI コンテナ・ServiceProvider との連携を通じ、Laravel の強みを活かしつつ DDD を実装

---

# 📘 業務フロー

<img width="2152" alt="業務フロー" src="https://github.com/user-attachments/assets/412ff388-9074-49a5-9cd0-0105125297bd" />

---

# 📘 画面要件書

---

## 📝 画面名：トップページ

### 1. 概要

ユーザーがシステムにアクセスした際の最初に表示される画面。新規ユーザー登録とログインへのリンクが表示される。

### 2. URL

`/`

### 3. 機能

-   新規ユーザー登録ページへのリンク
-   ログインページへのリンク

### 4. ボタン・リンク

| ラベル           | 種別   | 動作                                      |
| ---------------- | ------ | ----------------------------------------- |
| 新規ユーザー登録 | ボタン | 新規ユーザー登録ページ `/register` へ遷移 |
| ログイン         | ボタン | ログインページ `/login` へ遷移            |

---

## 📝 画面名：新規ユーザー登録画面

### 1. 概要

新規ユーザーがシステムに登録するための画面。ユーザー名、メールアドレス、パスワードの入力が必要。

### 2. URL

`/register`

### 3. 機能

-   ユーザー名、メールアドレス、パスワードの入力フォーム
-   入力バリデーション
-   登録ボタンのクリックでユーザーを登録

### 4. 入力項目

| 項目名         | 種別       | 必須 | バリデーション       | 備考             |
| -------------- | ---------- | ---- | -------------------- | ---------------- |
| ユーザー名     | テキスト   | ○    | 255 文字以内         | ユーザーの名前   |
| メールアドレス | テキスト   | ○    | メール形式、ユニーク | メール形式の入力 |
| パスワード     | パスワード | ○    | 8 文字以上           | セキュリティ強化 |

### 5. ボタン・リンク

| ラベル | 種別   | 動作                                   |
| ------ | ------ | -------------------------------------- |
| 登録   | ボタン | 登録後、ログインページ `/login` へ遷移 |

### 6. エラー表示例

-   「ユーザー名は必須です」
-   「メールアドレスは必須です」
-   「メールアドレスは正しい形式で入力してください」
-   「パスワードは 8 文字以上で入力してください」

---

## 📝 画面名：ログイン画面

### 1. 概要

ユーザーがシステムにログインするための画面。

### 2. URL

`/login`

### 3. 機能

-   メールアドレスとパスワードによるログイン
-   入力バリデーション
-   ログイン失敗時のエラーメッセージ表示

### 4. 入力項目

| 項目名         | 種別       | 必須 | バリデーション | 備考                 |
| -------------- | ---------- | ---- | -------------- | -------------------- |
| メールアドレス | テキスト   | ○    | メール形式     | 半角英数字、@を含む  |
| パスワード     | パスワード | ○    | 8 文字以上     | 英数字記号混在を推奨 |

### 5. ボタン・リンク

| ラベル               | 種別   | 動作                                             |
| -------------------- | ------ | ------------------------------------------------ |
| ログイン             | ボタン | 認証成功時にダッシュボードへ遷移                 |
| パスワードを忘れた方 | リンク | パスワードリセット画面 `/forgot-password` へ遷移 |

### 6. エラー表示例

-   「メールアドレスは必須です」
-   「パスワードは 8 文字以上で入力してください」
-   「メールアドレスまたはパスワードが正しくありません」

---

## 📝 画面名：ダッシュボード

### 1. 概要

ログイン後に表示される画面で、ユーザーの投稿一覧が表示される。投稿タイトルをクリックすると投稿ページに遷移する。

### 2. URL

`/dashboard`

### 3. 機能

-   投稿一覧を表示
-   投稿タイトルをクリックすると投稿ページへ遷移
-   10 件以上の投稿がある場合、ページネーションが表示される
-   サイドメニューに「投稿」リンクと「ログアウト」リンクが表示される

### 4. ボタン・リンク

| ラベル     | 種別   | 動作                                  |
| ---------- | ------ | ------------------------------------- |
| 投稿       | リンク | 記事作成ページ `/posts/create` へ遷移 |
| ログアウト | リンク | ログアウト処理後、トップページへ遷移  |

---

## 📝 画面名：記事投稿作成画面

### 1. 概要

ユーザーが新しい記事を投稿するための画面。タイトルと内容を入力して、記事を投稿する。

### 2. URL

`/posts/create`

### 3. 機能

-   記事タイトルと内容の入力フォーム
-   入力バリデーション
-   記事投稿ボタンのクリックで記事を投稿

### 4. 入力項目

| 項目名   | 種別           | 必須 | バリデーション | 備考                             |
| -------- | -------------- | ---- | -------------- | -------------------------------- |
| タイトル | テキスト       | ○    | 255 文字以内   | 記事タイトル                     |
| 内容     | テキストエリア | ○    | 10000 文字以内 | 記事本文（マークダウン対応など） |

### 5. ボタン・リンク

| ラベル     | 種別   | 動作                       |
| ---------- | ------ | -------------------------- |
| 投稿する   | ボタン | バリデーション後、投稿保存 |
| キャンセル | リンク | 一覧画面 `/posts` に戻る   |

---

## 📝 画面名：記事ページ

### 1. 概要

投稿した記事の詳細ページ。記事の内容や投稿者名が表示され、削除することもできる。

### 2. URL

`/user/{id}/post/{post_id}`

### 3. 機能

-   記事の詳細情報を表示
-   記事の削除機能（確認アラート後、削除）

### 4. ボタン・リンク

| ラベル       | 種別   | 動作                                     |
| ------------ | ------ | ---------------------------------------- |
| ホームへ戻る | ボタン | ダッシュボードページ `/dashboard` へ遷移 |
| 削除         | ボタン | 削除確認アラート後、記事削除             |

---

# 🗂 データ要件（テーブル定義）

![Image](https://github.com/user-attachments/assets/9e20d4b4-0f65-45d5-b0da-31f1ec7157f4)

## 🧑‍💻 `users` テーブル

| カラム名            | 型           | 制約                        | 説明                       |
| ------------------- | ------------ | --------------------------- | -------------------------- |
| `id`                | BIGINT       | PRIMARY KEY, AUTO_INCREMENT | ユーザー ID（主キー）      |
| `name`              | VARCHAR(255) | NOT NULL                    | ユーザー名                 |
| `email`             | VARCHAR(255) | NOT NULL, UNIQUE            | メールアドレス（ユニーク） |
| `email_verified_at` | TIMESTAMP    | NULLABLE                    | メール認証日時（任意）     |
| `password`          | VARCHAR(255) | NOT NULL                    | ハッシュ化されたパスワード |
| `remember_token`    | VARCHAR(100) | NULLABLE                    | ログイン保持用トークン     |
| `created_at`        | TIMESTAMP    | 自動生成                    | レコード作成日時           |
| `updated_at`        | TIMESTAMP    | 自動生成                    | レコード更新日時           |

---

## 📝 `posts` テーブル

| カラム名     | 型           | 制約                                        | 説明                          |
| ------------ | ------------ | ------------------------------------------- | ----------------------------- |
| `id`         | BIGINT       | PRIMARY KEY, AUTO_INCREMENT                 | 投稿 ID（主キー）             |
| `user_id`    | BIGINT       | FOREIGN KEY → `users.id`, ON DELETE CASCADE | 投稿者ユーザー ID（外部キー） |
| `title`      | VARCHAR(255) | NOT NULL                                    | 投稿タイトル                  |
| `content`    | TEXT         | NOT NULL                                    | 投稿内容                      |
| `created_at` | TIMESTAMP    | 自動生成                                    | 投稿作成日時                  |
| `updated_at` | TIMESTAMP    | 自動生成                                    | 投稿更新日時                  |

---

## 🔗 テーブルリレーション

-   **1 人のユーザー** は **複数の投稿** を持つ（`users` ⇨ `posts` の 1 対多リレーション）
-   投稿は、ユーザー削除とともに自動削除される（`ON DELETE CASCADE`）

🧩 関連とドメインモデリング

    User は複数の Post を持つ（1対多のリレーション）

    投稿者が削除されると、関連する投稿もすべて削除される（ON DELETE CASCADE）

    DDDでは User エンティティと Post エンティティとしてドメイン層に存在

    永続化は UserRepositoryInterface, PostRepositoryInterface 経由で行う
