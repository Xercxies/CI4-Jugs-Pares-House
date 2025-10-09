<?php
// app/Views/user/moodBoard.php
// Simple Mood Board view for CI4.
// Expects $moodItems = [
//   ['title'=>'', 'image'=>'', 'tags'=>['tag1'], 'colors'=>['#ffffff'], 'description'=>'']
// ];
if (!isset($moodItems) || !is_array($moodItems)) {
    // fallback sample data
    $moodItems = [
        [
            'title' => 'Warm Sunset',
            'image' => 'https://images.unsplash.com/photo-1501973801540-537f08ccae7b?w=1200&q=80&auto=format&fit=crop',
            'tags' => ['warm', 'sunset', 'landscape'],
            'colors' => ['#FF7A59', '#FFD29D', '#6A4C93'],
            'description' => 'Soft warm tones inspired by a tropical sunset.'
        ],
        [
            'title' => 'Muted Minimal',
            'image' => 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=1200&q=80&auto=format&fit=crop',
            'tags' => ['minimal', 'muted', 'interior'],
            'colors' => ['#F5F7FA', '#BFC7D6', '#6B7280'],
            'description' => 'Clean, muted palette for calm interfaces.'
        ],
        [
            'title' => 'Vivid Pop',
            'image' => 'https://images.unsplash.com/photo-1501004318641-b39e6451bec6?w=1200&q=80&auto=format&fit=crop',
            'tags' => ['vibrant', 'retro'],
            'colors' => ['#FF3B3F', '#FFB830', '#22D3EE'],
            'description' => 'High-contrast, energetic colors with retro vibes.'
        ],
    ];
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Mood Board</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind via CDNJS (project convention) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
        }

        /* small enhancement for color swatches focus */
        .swatch:focus {
            outline: 2px solid rgba(0, 0, 0, 0.15);
            outline-offset: 2px;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <h1 class="text-xl font-semibold">Mood Board</h1>
            <div class="text-sm text-gray-500">Curate palettes, images and tags</div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        <section class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <form class="flex items-center gap-2 w-full sm:w-2/3" onsubmit="return false;">
                <label for="search" class="sr-only">Search mood items</label>
                <input id="search" type="search" placeholder="Search title or tag..." class="w-full px-3 py-2 rounded-md border border-gray-200 shadow-sm focus:ring-2 focus:ring-indigo-200" oninput="filterItems()" />
                <button type="button" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700" onclick="resetFilters()">Reset</button>
            </form>

            <div class="flex items-center gap-3">
                <button class="px-3 py-2 bg-white border rounded-md text-sm" onclick="openCreateSample()">+ Add Sample</button>
                <span class="text-xs text-gray-500">Tip: click a card to view larger</span>
            </div>
        </section>

        <section id="board" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" aria-live="polite">
            <?php foreach ($moodItems as $idx => $item): ?>
                <article class="card bg-white rounded-lg shadow-sm overflow-hidden cursor-pointer group" tabindex="0"
                    data-title="<?= esc($item['title']) ?>"
                    data-tags="<?= esc(implode(' ', $item['tags'] ?? [])) ?>"
                    onkeydown="if(event.key==='Enter'){openModal(<?= $idx ?>)}"
                    onclick="openModal(<?= $idx ?>)">
                    <div class="relative h-44 bg-gray-100">
                        <img src="<?= esc($item['image']) ?>" alt="<?= esc($item['title']) ?>" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy">
                    </div>
                    <div class="p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h2 class="text-lg font-semibold"><?= esc($item['title']) ?></h2>
                                <div class="mt-1 text-xs text-gray-500"><?= esc($item['description']) ?></div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-gray-400">Tags</div>
                                <div class="mt-1 flex flex-wrap gap-1 justify-end">
                                    <?php foreach ($item['tags'] as $t): ?>
                                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded"><?= esc($t) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 flex items-center gap-2">
                            <?php foreach ($item['colors'] as $cidx => $color): ?>
                                <button title="Copy <?= esc($color) ?>" class="swatch w-8 h-8 rounded-md border border-gray-200 shadow-sm" style="background: <?= esc($color) ?>;" onclick="event.stopPropagation(); copyColor('<?= esc($color) ?>')" aria-label="Copy color <?= esc($color) ?>"></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    </main>

    <!-- Modal -->
    <div id="previewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-40" aria-hidden="true">
        <div role="dialog" aria-modal="true" aria-labelledby="previewTitle" class="bg-white rounded-lg max-w-4xl w-full mx-4 overflow-hidden shadow-xl">
            <div class="flex items-center justify-between p-4 border-b">
                <h3 id="previewTitle" class="text-lg font-semibold"></h3>
                <div class="flex items-center gap-2">
                    <button id="copyPaletteBtn" class="px-3 py-1 text-sm bg-indigo-600 text-white rounded" aria-label="Copy palette">Copy Palette</button>
                    <button id="closeModalBtn" class="px-3 py-1 bg-gray-100 rounded" aria-label="Close preview">Close</button>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="h-80 lg:h-auto">
                    <img id="previewImage" src="" alt="" class="w-full h-full object-cover">
                </div>
                <div class="p-4">
                    <p id="previewDesc" class="text-sm text-gray-700"></p>
                    <div id="previewTags" class="mt-4 flex flex-wrap gap-2"></div>
                    <div id="previewColors" class="mt-4 flex items-center gap-2"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Small unobtrusive JS, accessible patterns (Escape to close)
        const items = <?= json_encode($moodItems, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
        const modal = document.getElementById('previewModal');
        const previewImage = document.getElementById('previewImage');
        const previewTitle = document.getElementById('previewTitle');
        const previewDesc = document.getElementById('previewDesc');
        const previewTags = document.getElementById('previewTags');
        const previewColors = document.getElementById('previewColors');
        const copyPaletteBtn = document.getElementById('copyPaletteBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');

        function openModal(index) {
            const item = items[index];
            if (!item) return;
            previewImage.src = item.image;
            previewImage.alt = item.title;
            previewTitle.textContent = item.title;
            previewDesc.textContent = item.description || '';
            previewTags.innerHTML = '';
            (item.tags || []).forEach(t => {
                const el = document.createElement('span');
                el.className = 'text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded';
                el.textContent = t;
                previewTags.appendChild(el);
            });
            previewColors.innerHTML = '';
            (item.colors || []).forEach(c => {
                const btn = document.createElement('button');
                btn.className = 'w-10 h-10 rounded-md border border-gray-200 shadow-sm';
                btn.style.background = c;
                btn.title = 'Copy ' + c;
                btn.onclick = (e) => {
                    e.stopPropagation();
                    copyColor(c);
                };
                previewColors.appendChild(btn);
            });

            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            modal.setAttribute('aria-hidden', 'false');
            // focus trap: focus close button
            closeModalBtn.focus();
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
        }

        closeModalBtn.addEventListener('click', closeModal);
        copyPaletteBtn.addEventListener('click', () => {
            const colors = Array.from(previewColors.children).map(b => {
                // read computed background
                return window.getComputedStyle(b).backgroundColor || '';
            }).filter(Boolean).join(', ');
            if (colors) {
                navigator.clipboard?.writeText(colors).then(() => {
                    copyPaletteBtn.textContent = 'Copied!';
                    setTimeout(() => copyPaletteBtn.textContent = 'Copy Palette', 1200);
                }).catch(() => {
                    alert('Could not copy palette.');
                });
            }
        });

        // Click outside to close
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        // Escape to close
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.getAttribute('aria-hidden') === 'false') closeModal();
        });

        function copyColor(hex) {
            if (!hex) return;
            const text = hex;
            navigator.clipboard?.writeText(text).then(() => {
                // small visual cue
                const notice = document.createElement('div');
                notice.className = 'fixed bottom-4 right-4 bg-gray-800 text-white px-3 py-2 rounded shadow';
                notice.textContent = 'Color copied: ' + text;
                document.body.appendChild(notice);
                setTimeout(() => notice.remove(), 1500);
            }).catch(() => alert('Could not copy color.'));
        }

        // Simple client-side filtering
        function filterItems() {
            const q = document.getElementById('search').value.trim().toLowerCase();
            const cards = document.querySelectorAll('#board > article.card');
            cards.forEach(card => {
                const title = (card.dataset.title || '').toLowerCase();
                const tags = (card.dataset.tags || '').toLowerCase();
                if (!q || title.includes(q) || tags.includes(q)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function resetFilters() {
            document.getElementById('search').value = '';
            filterItems();
        }

        // allow adding a sample item client-side (non-persistent) for quick prototyping
        function openCreateSample() {
            const sample = {
                title: 'New Sample',
                image: 'https://images.unsplash.com/photo-1496307042754-b4aa456c4a2d?w=1200&q=80&auto=format&fit=crop',
                tags: ['sample'],
                colors: ['#E879F9', '#60A5FA', '#34D399'],
                description: 'A quick sample item.'
            };
            items.push(sample);
            // re-render last card
            const board = document.getElementById('board');
            const idx = items.length - 1;
            const article = document.createElement('article');
            article.className = 'card bg-white rounded-lg shadow-sm overflow-hidden cursor-pointer group';
            article.tabIndex = 0;
            article.dataset.title = sample.title;
            article.dataset.tags = sample.tags.join(' ');
            article.onclick = () => openModal(idx);
            article.onkeydown = (e) => {
                if (e.key === 'Enter') openModal(idx);
            };
            article.innerHTML = `
        <div class="relative h-44 bg-gray-100">
          <img src="${sample.image}" alt="${sample.title}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy">
        </div>
        <div class="p-4">
          <div class="flex items-start justify-between gap-3">
            <div>
              <h2 class="text-lg font-semibold">${sample.title}</h2>
              <div class="mt-1 text-xs text-gray-500">${sample.description}</div>
            </div>
            <div class="text-right">
              <div class="text-xs text-gray-400">Tags</div>
              <div class="mt-1 flex flex-wrap gap-1 justify-end">
                ${sample.tags.map(t => `<span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded">${t}</span>`).join('')}
              </div>
            </div>
          </div>
          <div class="mt-3 flex items-center gap-2">
            ${sample.colors.map(c => `<button title="Copy ${c}" class="swatch w-8 h-8 rounded-md border border-gray-200 shadow-sm" style="background:${c};" onclick="event.stopPropagation(); copyColor('${c}')"></button>`).join('')}
          </div>
        </div>
      `;
            board.prepend(article);
            article.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }
    </script>
</body>

</html>