<!DOCTYPE html>
<html>
    <head>
        <title>Transactions</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                text-align: center;
            }

            table tr th, table tr td {
                padding: 5px;
                border: 1px #eee solid;
            }

            tfoot tr th, tfoot tr td {
                font-size: 20px;
            }

            tfoot tr th {
                text-align: right;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Check #</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(!(empty($transactions))){
                    echo get_html_table($transactions);
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td>
                        <?php
                        if(!(empty($transactions))){
                            echo formatDollarAmount(get_total_income($transactions));
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td>
                        <?php
                        if(!(empty($transactions))){
                            echo formatDollarAmount(get_total_expense($transactions));
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td>
                        <?php
                        if(!(empty($transactions))){
                            echo formatDollarAmount(get_net_total($transactions));
                        }
                        ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
