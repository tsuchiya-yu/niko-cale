# 環境構築

1. **リポジトリをクローンする**
   - 最初に、プロジェクトのリポジトリをローカル環境にクローンします。
     ```shell
     git clone https://github.com/tsuchiya-yu/niko-cale.git
     cd niko-cale
     ```

2. **Dockerコンテナのビルド**
   - Dockerを使用しているため、以下のコマンドでコンテナイメージをビルドします。
     ```shell
     docker compose build
     ```

3. **コンテナの起動**
   - コンテナをバックグラウンドで起動します。
     ```shell
     make up-d
     ```

4. **マイグレーションの実行**
   - 起動したコンテナ内でLaravelのマイグレーションを実行します。
     ```shell
     make app
     php artisan migrate
     ```

5. **npm開発環境の起動**
   - フロントエンド開発のために、`npm run dev` コマンドを実行します。これにより、Viteサーバーが起動し、ライブリロードを行いながら開発できます。
     ```shell
     make npm-dev
     ```

6. **ブラウザで確認**
   - ブラウザを開き、`http://localhost:8000/` にアクセスします。アプリケーションが正常に起動していれば、環境構築は完了です。

# 開発コマンド

- **Viteの実行 (画面を見る時)**
  - 開発中にフロントエンドの変更をリアルタイムで確認するため、Viteを実行します。
    ```shell
    make npm-dev
    ```

- **コンテナの実行**
  - Dockerコンテナを起動して、アプリケーションの開発環境を立ち上げます。
    ```shell
    make app
    ```

- **Pintの実行**
  - Laravel Pintはコードのスタイルをチェックし、修正します。以下のコマンドで実行します。
    ```shell
    make pint
    ```

- **IDEヘルパーの更新**
  - IDEヘルパーを更新して、IDEの補完機能を強化します。特にLaravelの開発で役立ちます。
    ```shell
    make ide
    ```

- **テストの実行**
  - テストコードを実行します。
    ```shell
    make test
    ```