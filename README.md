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
