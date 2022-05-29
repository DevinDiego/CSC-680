<!-- strtok() splits a string (string) into smaller strings (tokens), with each token being delimited by any character from token. That is, if you have a string like "This is an example string" you could tokenize this string into its individual words by using the space character as the token. -->

<?php $base = strtok($_SERVER['REQUEST_URI'], '?'); ?>

<ul class="nav justify-content-center">
        <li class="nav-item">
            <?php if ($paginator->previous): ?>
                <a class="nav-link" href="<?=$base; ?>?page=<?= $paginator->previous; ?>">Previous</a>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link disabled">Previous</a>
                </li>
            <?php endif; ?>
        </li>

        <li class="nav-item">
            <?php if ($paginator->next) : ?>
                <a class="nav-link" href="<?=$base; ?>?page=<?= $paginator->next; ?>">Next</a>
            <?php else : ?>
                <li class="nav-item">
                    <a class="nav-link disabled">Next</a>
                <?php endif; ?>
            </li>
        </li>
    </ul>