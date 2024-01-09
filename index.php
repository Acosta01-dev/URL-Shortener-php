<?php
session_start();

include __DIR__ . DIRECTORY_SEPARATOR . "php" . DIRECTORY_SEPARATOR . "config.php";

if (isset($_GET["url"])) {
    $short_code = $_GET["url"];

    $stmt = $conn->prepare("SELECT long_url FROM url_shortener WHERE short_code = :short_code");
    $stmt->bindParam(":short_code", $short_code);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $stmt = $conn->prepare("UPDATE url_shortener SET used = used + 1 WHERE short_code = :short_code");
        $stmt->bindParam(":short_code", $short_code);
        $stmt->execute();

        $redirect_url = $result['long_url'];

        if (!preg_match("~^(?:f|ht)tps?://~i", $redirect_url)) {
            $redirect_url = "http://" . $redirect_url;
        }

        header("Location: " . $redirect_url);
        exit();
    } else {
        header("Location: index.php");
        exit();
    }
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./style/style.css">
</head>

<body>
    <form class="container" style="max-width: 600px;" method="POST" action="./php/shortenurl.php" id="url_form">
        <div class="input-group mt-5">
            <span class="input-group-text" id="basic-addon1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-link-45deg" viewBox="0 0 16 16">
                    <path d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1 1 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4 4 0 0 1-.128-1.287z" />
                    <path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243z" />
                </svg>
            </span>
            <input type="text" class="form-control" <?= ($_SESSION["last_url"] ?? '') === "Place long URL here" ? 'placeholder="Place long URL here"' : 'value="' . ($_SESSION["last_url"] ?? 'Paste a long URL') . '"' ?> name="full_url" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mt-1">
            <input type="text" class="form-control" id="short_url" name="short_url" <?= ($_SESSION["last_code"] ?? '') === "Invalid URL" ? 'placeholder="Invalid URL"' : 'value="' . ($_SESSION["last_code"] ?? 'Shortened URL') . '"' ?> aria-label="short_url" readonly>
            <span id="copy_btn" class="input-group-text" style="background-color: gray; color: white; cursor:pointer;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard" viewBox="0 0 16 16">
                    <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z" />
                    <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z" />
                </svg>
            </span>
        </div>

        <input class="btn btn-secondary mt-2" id="send_btn" type="submit" value="Shorten URL">

    </form>
    <div class="container mt-5 pt-3">
        <?php
        $stmt = $conn->prepare("SELECT * FROM url_shortener ORDER BY id DESC LIMIT 10");
        $stmt->execute();
        ?>
        <label for="basic-url" class="form-label">Shorten URLs history (Max:10)</label>
        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Shorten URL</th>
                        <th>Original URL</th>
                        <th>Used</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td><?= "localhost/php/short/?url=" . $row["short_code"] ?></td>
                            <td><?= $row["long_url"] ?></td>
                            <td><?= $row["used"] ?> Times</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="app/app.js"></script>

</body>

</html>