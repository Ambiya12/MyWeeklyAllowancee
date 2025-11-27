<main class="main">
    <?php if ($message): ?>
        <div class="message <?= $messageType ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <!-- STATISTICS -->
    <div class="stats">
        <div class="stat-card">
            <div class="stat-number"><?= count($teens) ?></div>
            <div class="stat-label">Teens</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= number_format($totalBalance, 2) ?>€</div>
            <div class="stat-label">Total Balance</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= number_format($totalSpent, 2) ?>€</div>
            <div class="stat-label">Total Spent</div>
        </div>
    </div>

    <!-- WALLETS -->
    <div class="wallets-section">
        <div class="section-header">
            <h2>👛 Wallets</h2>
        </div>
        
        <?php if ($teens): ?>
            <?php foreach ($teens as $teen): 
                $wallet = $fm->getWallet($teen);
                $history = $wallet->getHistory();
                $transactions = count($history);
                $spent = 0;
                foreach ($history as $t) {
                    $spent += $t['amount'];
                }
            ?>
                <div class="wallet-card">
                    <div class="wallet-header" onclick="toggleHistory('<?= htmlspecialchars($teen) ?>')">
                        <div class="wallet-details">
                            <h3><?= htmlspecialchars($teen) ?></h3>
                            <div class="wallet-meta">
                                <span><?= $transactions ?> transactions</span>
                                <span>·</span>
                                <span><?= number_format($spent, 2) ?>€ spent</span>
                                <span>·</span>
                                <span><?= number_format($wallet->getAllowance(), 2) ?>€/week</span>
                            </div>
                            <div class="history-toggle" id="toggle-<?= htmlspecialchars($teen) ?>">
                                ▼ Show history
                            </div>
                        </div>
                        <div class="wallet-balance">
                            <div class="balance-amount"><?= number_format($wallet->getBalance(), 2) ?>€</div>
                            <div class="balance-label">Balance</div>
                        </div>
                    </div>
                    
                    <div class="history-section" id="history-<?= htmlspecialchars($teen) ?>">
                        <div class="history-title">📜 Transaction History</div>
                        <?php if ($transactions > 0): ?>
                            <?php 
                            $reversedHistory = array_reverse($history);
                            foreach ($reversedHistory as $transaction): 
                            ?>
                                <div class="transaction">
                                    <div class="transaction-info">
                                        <div class="transaction-desc">
                                            <?= $transaction['description'] ?: 'Spending' ?>
                                        </div>
                                        <div class="transaction-date">
                                            <?= $transaction['date']->format('M d, Y - H:i') ?>
                                        </div>
                                    </div>
                                    <div class="transaction-amount">
                                        -<?= number_format($transaction['amount'], 2) ?>€
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-history">No transactions yet</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-state-icon">👛</div>
                <h3>No Wallets Yet</h3>
                <p>Add your first teen from the sidebar</p>
            </div>
        <?php endif; ?>
    </div>
</main>
