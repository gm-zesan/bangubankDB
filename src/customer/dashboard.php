<?php
    include('includes/header.php');

    $loggedInUserEmail = $session->get('user');
    $transactions = $transaction->getTransactionByUser($loggedInUserEmail);

    usort($transactions, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });
?>

            <header class="py-10">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold tracking-tight text-white">
                        Howdy, <?= $session->get('name'); ?>!
                    </h1>
                </div>
            </header>
        </div>

        <main class="-mt-32">
            <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg p-2">
                    <!-- Current Balance Stat -->
                    <dl
                        class="mx-auto grid grid-cols-1 gap-px sm:grid-cols-2 lg:grid-cols-4">
                        <div
                            class="flex flex-wrap items-baseline justify-between gap-x-4 gap-y-2 bg-white px-4 py-10 sm:px-6 xl:px-8">
                            <dt class="text-sm font-medium leading-6 text-gray-500">
                                Current Balance
                            </dt>
                            <dd
                                class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">
                                $<?= number_format($balance, 2); ?>
                            </dd>
                        </div>
                    </dl>

                    <!-- List of All The Transactions -->
                    <div class="px-4 sm:px-6 lg:px-8">
                        <div class="sm:flex sm:items-center">
                            <div class="sm:flex-auto">
                                <p class="mt-2 text-sm text-gray-700">
                                    Here's a list of all your transactions which inlcuded
                                    receiver's name, email, amount and date.
                                </p>
                            </div>
                        </div>
                        <div class="mt-8 flow-root">
                            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div
                                    class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                    <?php if (!empty($transactions)): ?>
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead>
                                            <tr>
                                                <th
                                                    scope="col"
                                                    class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                                    Receiver Name
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                                    Email
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Amount
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Date
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 bg-white">


                                        <?php foreach ($transactions as $transaction): ?>
                                            <tr>
                                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-800 sm:pl-0">
                                                    <?= in_array($transaction['type'], ['deposit', 'withdraw', 'received']) ? htmlspecialchars($user->getUserNameByEmail($transaction['email'])) : htmlspecialchars($user->getUserNameByEmail($transaction['recipient'])) ?>
                                                </td>
                                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">
                                                    <?= in_array($transaction['type'], ['deposit', 'withdraw', 'received']) ? $transaction['email'] : $transaction['recipient'] ?>
                                                </td>
                                                <td class="whitespace-nowrap px-2 py-4 text-sm font-medium text-<?= in_array($transaction['type'], ['deposit', 'received']) ? 'emerald' : 'red' ?>-600">
                                                    <?= in_array($transaction['type'], ['deposit', 'received']) ? '+' : '-' ?>
                                                    $<?= number_format($transaction['amount'], 2) ?>
                                                </td>
                                                <td class="whitespace-nowrap px-2 py-4 text-sm text-gray-500">
                                                    <?= date('d M Y, h:i A', strtotime($transaction['date'])) ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>


                                        </tbody>
                                    </table>
                                    <?php else: ?>
                                        <p>No transactions recorded yet.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>