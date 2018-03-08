<?php if (!empty($settings->headers) && !empty($settings->rows)) : ?>
    <div class="table">
        <div class="table-responsive">
            <table>
                <tbody>
                <tr>
                    <?php foreach ($settings->headers as $header_i => $header) : ?>
                        <?php !empty($header) && print "<th>$header</th>"; ?>
                    <?php endforeach; ?>
                </tr>
                <?php foreach ($settings->rows as $row_i => $row) : ?>
                    <tr>
                        <?php foreach ($row->cell as $cell_i => $cell) : ?>
                            <?php !empty($cell) && print "<td>$cell</td>"; ?>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div><!-- end table-holder -->
    </div><!-- end table-section -->
<?php endif; ?>
