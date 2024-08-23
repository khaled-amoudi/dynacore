<!DOCTYPE html>
<html>

<head>
    <title>Categories</title>
    <style>
        table{
            border-collapse: collapse !important;
            border-color: rgb(106, 106, 106) !important;
        }
        th, td {
            padding: 5px !important;
        }
        thead, thead th {
            background-color: rgb(227, 133, 133);
            color: #fff;
        }
    </style>
</head>

<body>
    <table border="1" width="100%">
        <thead>
            <tr>
                @foreach ($headings as $th)
                <th scope="col">{{ $th }}</th>
                @endforeach
                {{-- <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Parent ID</th>
                <th scope="col">Status</th> --}}
            </tr>
        </thead>
        {{-- <tfoot>
            <tr>
                <td colspan="4">This is the foot of the table</td>
            </tr>
        </tfoot> --}}
        <tbody>
            @foreach ($collection as $data)
                <tr>
                    @foreach ($collection_array as $item)
                        <td>{{ $data[$item] }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
