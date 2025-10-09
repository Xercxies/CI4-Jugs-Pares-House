<?php
// app/Views/users/roadMap.php
// Simple, responsive roadmap/timeline view for CodeIgniter 4 using Tailwind (CDN).
// If a $milestones array is provided, it will be used. Otherwise, a default roadmap is shown.

if (!isset($milestones) || !is_array($milestones)) {
    $milestones = [
        ['title' => 'Discovery & Planning', 'date' => '2025-01', 'desc' => 'Requirements gathering, stakeholder interviews, scope.', 'status' => 'done'],
        ['title' => 'Design & Prototyping', 'date' => '2025-02', 'desc' => 'Wireframes, UI mockups, prototyping and approval.', 'status' => 'done'],
        ['title' => 'Core Development', 'date' => '2025-03 - 2025-05', 'desc' => 'Backend services, database, APIs, frontend integration.', 'status' => 'in_progress'],
        ['title' => 'Testing & QA', 'date' => '2025-06', 'desc' => 'Unit, integration, and acceptance testing. Bug fixes.', 'status' => 'pending'],
        ['title' => 'Launch', 'date' => '2025-07', 'desc' => 'Release to production, monitoring, and rollback plan.', 'status' => 'pending'],
        ['title' => 'Maintenance & Iteration', 'date' => 'Ongoing', 'desc' => 'Support, small enhancements, and performance tuning.', 'status' => 'pending'],
    ];
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Project Roadmap</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        /* Minor visual tweaks for the vertical connector */
        .timeline-line::before {
            content: '';
            position: absolute;
            left: 1.375rem;
            /* aligns with center of the dots */
            top: 1.25rem;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, rgba(59, 130, 246, 0.9), rgba(203, 213, 225, 0.6));
            transform-origin: top;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <main class="max-w-4xl mx-auto p-6">
        <header class="mb-8">
            <h1 class="text-2xl font-semibold text-gray-900">Project Roadmap</h1>
            <p class="text-sm text-gray-600 mt-1">High-level timeline of milestones and progress.</p>
        </header>

        <section aria-label="Roadmap timeline" class="relative">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow p-4">
                        <h2 class="text-lg font-medium">Milestones</h2>
                        <p class="text-sm text-gray-500 mt-1">Statuses: Done, In progress, Pending.</p>
                    </div>
                </div>
                <div class="md:col-span-1">
                    <div class="bg-white rounded-lg shadow p-4">
                        <h3 class="text-sm font-medium text-gray-700">Legend</h3>
                        <ul class="mt-3 space-y-2 text-sm">
                            <li class="flex items-center"><span class="h-3 w-3 rounded-full bg-blue-600 inline-block mr-2"></span> Done</li>
                            <li class="flex items-center"><span class="h-3 w-3 rounded-full bg-yellow-500 inline-block mr-2"></span> In progress</li>
                            <li class="flex items-center"><span class="h-3 w-3 rounded-full bg-gray-300 inline-block mr-2"></span> Pending</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="relative">
                <ol class="space-y-8 timeline-line pl-8">
                    <?php foreach ($milestones as $index => $m):
                        $status = $m['status'] ?? 'pending';
                        $isDone = $status === 'done';
                        $isInProgress = $status === 'in_progress';
                        $dotBg = $isDone ? 'bg-blue-600' : ($isInProgress ? 'bg-yellow-500' : 'bg-gray-300');
                        $dotIcon = $isDone
                            ? '<svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" aria-hidden><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'
                            : ($isInProgress ? '<span class="text-white text-xs font-semibold">…</span>' : '');
                    ?>
                        <li class="relative">
                            <div class="absolute -left-8 top-0 flex items-start">
                                <div class="flex items-center justify-center h-8 w-8 rounded-full <?php echo $dotBg; ?> text-white shadow"><?php echo $dotIcon; ?></div>
                            </div>

                            <div class="bg-white border border-gray-100 rounded-lg p-4 shadow-sm">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h3 class="text-md font-semibold text-gray-900"><?php echo htmlspecialchars($m['title']); ?></h3>
                                        <p class="text-xs text-gray-500 mt-1"><?php echo htmlspecialchars($m['date']); ?></p>
                                    </div>
                                    <div class="ml-4">
                                        <?php if ($isDone): ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">Done</span>
                                        <?php elseif ($isInProgress): ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">In progress</span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Planned</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <p class="mt-3 text-sm text-gray-600"><?php echo htmlspecialchars($m['desc']); ?></p>

                                <?php if (isset($m['progress']) && is_numeric($m['progress'])):
                                    $p = max(0, min(100, (int)$m['progress']));
                                ?>
                                    <div class="mt-3">
                                        <div class="w-full bg-gray-100 rounded-full h-2">
                                            <div class="h-2 rounded-full <?php echo $isDone ? 'bg-blue-600' : ($isInProgress ? 'bg-yellow-500' : 'bg-gray-300'); ?>" style="width: <?php echo $p; ?>%"></div>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1"><?php echo $p; ?>% complete</div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </section>
    </main>
</body>

</html>