<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .edit{
            width: 100%;
            height: 25px;
        }
        .editMode{
            border: 1px solid black;
        }
        table, th, td {
            border: 1px solid black;
        }
    </style>
    <script>
        $(document).ready(function(){

            // Add Class
            $('.edit').click(function(){
                $(this).addClass('editMode');
            });

            // Save data
            $(".edit").focusout(function(){
                $(this).removeClass("editMode");
                var id = this.id;
                var split_id = id.split("_");
                var field_name = split_id[0];
                var edit_id = split_id[1];
                var value = $(this).text();

                $.ajax({
                    url: 'link.php',//файл с php скриптом, обновляющий данные в бд
                    type: 'post',
                    data: { field:field_name, value:value, id:edit_id },// отправляем имя поля, новое значение и id, чтобы определить, что конкретно и как надо обновить в таблице
                    success:function(response){
                        console.log('Save successfully');
                    }
                });
            });
        });
    </script>
</head>
<body>
<div class='container'>
    <table>
        <tr>
            <th>Id</th>
            <th>field</th>
            <th>value</th>
        </tr>
        <?php
        $link=mysqli_connect('localhost','root','','kva-kva') or die(mysqli_error($link));
        $query2 = mysqli_query($link, "SELECT * FROM users");

        while($row = mysqli_fetch_array($query2)){
            $id=$row['id'];
            $field=$row['field'];
            $value=$row['value'];
            echo "<tr> 
        <td>$id</td> 
        <td contentEditable='true' class='edit' id='field_$id'>$field</td> 
        <td contentEditable='true' class='edit' id='value_$id'>$value</td> 
        </tr>";
        }
        ?>
    </table>
    <table>
        <tr>
            <th>
                <form method=post>
                    <input type=submit name=button value='Добавить'>
                    <?php

                    $har = mysqli_query($link, "SELECT * FROM users");
                    $num_rows = mysqli_num_rows( $har );

                    if(isset($_POST['button'])){
                        $but = mysqli_query($link, "INSERT INTO mydatabase (id) VALUES ($num_rows)");
                        header("Location: temp.php");
                    }?>
                </form>
            </th>
        </tr>
    </table>
</div>
</body>
</html>
