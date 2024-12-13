<?php
// Maandnamen array
$month_names = [
    '01' => 'Januari', '02' => 'Februari', '03' => 'Maart', '04' => 'April',
    '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Augustus',
    '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'December'
];
?>

<form id="ic-agenda-filters">
    <h2>Filter</h2>

    <!-- Maandenfilter -->
    <div class="ic-agenda-filter-row">
        <label class="ic-agenda-filter-label">
            <input type="checkbox" name="filter_months[]" value="all" <?php echo in_array($current_month, $months) ? '' : 'checked'; ?>>
            <span>Alle Maanden</span>
        </label>
        <?php foreach ($months as $month): ?>
            <label class="ic-agenda-filter-label">
                <input type="checkbox" name="filter_months[]" value="<?php echo esc_attr($month); ?>" <?php echo ($month == $current_month) ? 'checked' : ''; ?>>
                <span><?php echo isset($month_names[$month]) ? esc_html($month_names[$month]) : esc_html($month); ?></span>
            </label>
        <?php endforeach; ?>
    </div>

    <div class="divider"></div>

    <!-- Jarenfilter -->
    <div class="ic-agenda-filter-row">
        <label class="ic-agenda-filter-label">
            <input type="checkbox" name="filter_years[]" value="all" <?php echo in_array($current_year, $years) ? '' : 'checked'; ?>>
            <span>Alle Jaren</span>
        </label>
        <?php foreach ($years as $year): ?>
            <label class="ic-agenda-filter-label">
                <input type="checkbox" name="filter_years[]" value="<?php echo esc_attr($year); ?>" <?php echo ($year == $current_year) ? 'checked' : ''; ?>>
                <span><?php echo esc_html($year); ?></span>
            </label>
        <?php endforeach; ?>
    </div>
</form>
