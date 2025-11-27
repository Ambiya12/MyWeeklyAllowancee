<aside class="sidebar">
    <div class="logo">
        <div class="logo-icon">💰</div>
        <h1>MyWeeklyAllowance</h1>
        <p>Manage your teens' pocket money</p>
    </div>

    <!-- ADD TEEN PANEL -->
    <div class="panel">
        <div class="panel-title">👤 Add New Teen</div>
        <form method="post">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label class="form-label">Teen's Name</label>
                <input type="text" name="name" placeholder="e.g. Galystan" required>
            </div>
            <div class="form-group">
                <label class="form-label">Weekly Allowance</label>
                <input type="number" name="amount" step="0.01" min="0" value="0" placeholder="0.00">
                <div class="help-text">Amount in euros (€)</div>
            </div>
            <button type="submit" class="btn btn-primary">Add Teen</button>
        </form>
    </div>

    <?php if ($teens): ?>
    <!-- TRANSACTION PANEL -->
    <div class="panel">
        <div class="panel-title">💳 Make Transaction</div>
        <form method="post">
            <div class="form-group">
                <label class="form-label">Select Teen</label>
                <select name="name" required>
                    <option value="">Choose a teen...</option>
                    <?php foreach ($teens as $teen): ?>
                        <option value="<?= htmlspecialchars($teen) ?>"><?= htmlspecialchars($teen) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Amount</label>
                <input type="number" name="amount" step="0.01" min="0.01" placeholder="0.00" required>
            </div>
            <div class="form-group">
                <label class="form-label">Description (optional)</label>
                <input type="text" name="description" placeholder="e.g. Lunch money">
                <div class="help-text">For spending transactions only</div>
            </div>
            <div class="btn-group">
                <button type="submit" name="action" value="deposit" class="btn btn-primary">Deposit</button>
                <button type="submit" name="action" value="spend" class="btn btn-secondary">Spend</button>
            </div>
        </form>
    </div>

    <!-- FOOTER ACTIONS -->
    <div class="footer-actions">
        <form method="post" style="margin-bottom: 0.75rem;">
            <input type="hidden" name="action" value="allowance">
            <button type="submit" class="btn btn-primary">💸 Process Weekly Allowances</button>
        </form>
        <form method="post">
            <input type="hidden" name="action" value="reset">
            <button type="submit" class="btn btn-secondary">Reset All Data</button>
        </form>
    </div>
    <?php endif; ?>
</aside>
