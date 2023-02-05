<!DOCTYPE html>

<title>By Blog</title>

<body>
    <?php foreach ($posts as $post) : ?>
        <div>
            <h1>
                <a href="/posts/<?= $post->slug ?>">
                    <?= $post->title ?>
                </a>
            </h1>
            <?= $post->body ?>
        </div>
    <?php endforeach; ?>
</body>
