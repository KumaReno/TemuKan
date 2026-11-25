<div class="item-grid" id="itemGrid" data-ssr-grid="true">
  <?php foreach ($items as $index => $item): ?>
    <?php $detailUrl = $item->getDetailUrl(); ?>
    <article
      class="item-card"
      data-number="<?= $index + 1 ?>"
      data-status="<?= $escape($item->getStatus()) ?>"
      data-search="<?= $escape($item->getSearchText()) ?>"
    >
      <a
        class="item-visual <?= $escape($item->getVisual()) ?>"
        href="<?= $escape($detailUrl) ?>"
        aria-label="Lihat detail <?= $escape($item->getName()) ?>"
      >
        <span class="visual-symbol"><?= $escape($item->getSymbol()) ?></span>
        <span class="visual-label"><?= $escape($item->getCategory()) ?></span>
        <span class="visual-scribble"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
      </a>

      <div class="item-content">
        <div class="item-meta">
          <span class="tag <?= $escape($item->getStatusTagClass()) ?>">
            <i></i> <?= $escape($item->getStatusLabel()) ?>
          </span>
          <span class="item-date"><?= $escape($item->getDate()) ?></span>
        </div>

        <h3>
          <a href="<?= $escape($detailUrl) ?>"><?= $escape($item->getName()) ?></a>
        </h3>
        <p class="item-location">
          <span>&#8982;</span> <?= $escape($item->getLocation()) ?>
        </p>

        <div class="item-footer">
          <span class="reporter">
            <span class="avatar <?= $escape($item->getAvatar()) ?>">
              <?= $escape($item->getInitials()) ?>
            </span>
            <?= $escape($item->getReporter()) ?>
          </span>
          <a
            class="card-arrow"
            href="<?= $escape($detailUrl) ?>"
            aria-label="Buka detail"
          >
            &#8599;
          </a>
        </div>
      </div>
    </article>
  <?php endforeach; ?>
</div>
