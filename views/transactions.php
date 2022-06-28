<!DOCTYPE html>
<html>
    <head>
        <title>Transactions</title>
        <link rel="stylesheet" href="homeStyle.css">
        <style>
            .btn{
                margin-top: 10px;
                margin-bottom: 20px;
            }

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
        <form action="/select" method="get" enctype="multipart/form-data">
            <input type="submit" class="btn" value="Upload new CSV file">
        </form>

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
                echo $this->params[0];
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td>
                        <?php
                        echo $this->params[1];
                        ?>
                    </td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td>
                        <?php
                        echo $this->params[2];
                        ?>
                    </td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td>
                        <?php
                        echo $this->params[3];
                        ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
