<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

$stmt = $pdo->query('SELECT id, name, age, status FROM users ORDER BY id DESC');
$users = $stmt->fetchAll();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A simple PHP, MySQL and AJAX status management task.">
    <title>StatusFlow | PHP & MySQL Task</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/app.js" defer></script>
</head>
<body>
    <main class="page-shell">
        <section class="hero">
            <div>
                <p class="eyebrow">Web Development Task</p>
                <h1>StatusFlow</h1>
                <p class="hero-copy">A lightweight PHP & MySQL dashboard with real-time AJAX updates.</p>
            </div>
            <div class="tech-stack" aria-label="Technologies used">
                <span>HTML</span><span>CSS</span><span>JavaScript</span><span>PHP</span><span>MySQL</span>
            </div>
        </section>

        <section class="card form-card" aria-labelledby="add-person-title">
            <div class="section-heading">
                <div>
                    <p class="kicker">New record</p>
                    <h2 id="add-person-title">Add a person</h2>
                </div>
                <span class="live-pill"><span class="live-dot"></span> Live database</span>
            </div>

            <form id="personForm" class="inline-form" autocomplete="off">
                <label class="field">
                    <span>Name</span>
                    <input id="name" name="name" type="text" maxlength="100" placeholder="e.g. Sarah" required>
                </label>

                <label class="field age-field">
                    <span>Age</span>
                    <input id="age" name="age" type="number" min="1" max="120" placeholder="25" required>
                </label>

                <button id="submitBtn" class="primary-btn" type="submit">
                    <span>Add record</span>
                    <span aria-hidden="true">→</span>
                </button>
            </form>

            <p id="formMessage" class="message" role="status" aria-live="polite"></p>
        </section>

        <section class="card table-card" aria-labelledby="records-title">
            <div class="section-heading records-heading">
                <div>
                    <p class="kicker">Database records</p>
                    <h2 id="records-title">People</h2>
                </div>
                <span id="recordCount" class="count-pill"><?= count($users) ?> record<?= count($users) === 1 ? '' : 's' ?></span>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="recordsBody">
                        <?php if (!$users): ?>
                            <tr id="emptyRow">
                                <td colspan="5" class="empty-state">No records yet. Add the first person above.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $user): ?>
                                <tr data-id="<?= (int)$user['id'] ?>">
                                    <td class="id-cell">#<?= (int)$user['id'] ?></td>
                                    <td class="name-cell"><?= htmlspecialchars((string)$user['name'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= (int)$user['age'] ?></td>
                                    <td>
                                        <span class="status-badge <?= (int)$user['status'] === 1 ? 'status-on' : 'status-off' ?>" data-status>
                                            <?= (int)$user['status'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="toggle-btn" type="button" data-toggle-id="<?= (int)$user['id'] ?>">
                                            Toggle
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <footer>
            <span>StatusFlow</span>
            <span>PHP • MySQL • Fetch API</span>
        </footer>
    </main>
</body>
</html>
