@extends('layouts')
@section('content')
<style>
        input[type="button"]
        {
        background-color:green;
        color: black;
        border: solid black 2px;
        width:100%
        }

        input[type="text"]
        {
        background-color:white;
        border: solid black 2px;
        width:100%
        }
</style>
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading" style="margin-bottom: 30px;">
            <i class="fa fa-home"></i> Thiết lập công thức
        </div>
        <div class="panel-body">
            <form action="{{ route('method.p_storeText') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group ">
                        <label class="control-label col-lg-2">Tử số bằng chữ:<br>
                            <button class="btn btn-xs btn-success" id="addTuso" type="button">
                                <i class="fa fa-plus"></i>
                            </button>
                            <button class="btn btn-xs btn-danger" id="removeTuso" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                        </label>
                        <div class="col-lg-10">
                            <div class="col-lg-3">
                                <input type="text" class="form-control" min="1" max="5" name="nameNumerator[]" required>
                            </div>
                            <div id="addMoreTuSoText">

                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group ">
                        <label class="control-label col-lg-2">Mẫu số bằng chữ:<br>
                            <button class="btn btn-xs btn-info" id="addMauso" type="button">
                                <i class="fa fa-plus"></i>
                            </button>
                            <button class="btn btn-xs btn-danger" id="removeMauso" type="button">
                                <i class="fa fa-times"></i>
                            </button>
                        </label>
                        <div class="col-lg-10">
                            <div class="col-lg-3">
                                <input type="text" class="form-control" min="1" max="5" name="nameDenominator[]"
                                    required>
                            </div>
                            <div id="addMoreMauso">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="space"></div>
                <div class="space"></div>
                <hr>
                <div class="row">
                    <div class="form-group ">
                        <label class="control-label col-lg-2">Tử số bằng số:<br>
                        </label>
                        <div class="col-lg-10">
                            <div class="col-lg-3">
                                <input type="number" class="form-control" min="1" value="1" name="numNumerator[]"
                                    required>
                            </div>
                            <div id="addMoreTuSoNum">

                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group ">
                        <label class="control-label col-lg-2">Mẫu số bằng số:<br>
                        </label>
                        <div class="col-lg-10">
                            <div class="col-lg-3">
                                <input type="number" class="form-control" min="1" value="1" name="numDenominator[]"
                                    required>
                            </div>
                            <div id="addMoreMausoNum">

                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row position-center">
                        <div class="col-xs-12 col-sm-6">
                            <div class="form-group">
                                <label>Nhập số liệu</label>
                                <table border="1">
                                        <tr>
                                            <td colspan="3"><input type="text" id="result" name="result" required /></td>
                                            <!-- clr() function will call clr to clear all value -->
                                            <td><input type="button" value="c" onclick="clr()" /> </td>
                                        </tr>
                                        <tr>
                                            <!-- create button and assign value to each button -->
                                            <!-- dis("1") will call function dis to display value -->
                                            <td><input type="button" value="1" onclick="dis('1')" /> </td>
                                            <td><input type="button" value="2" onclick="dis('2')" /> </td>
                                            <td><input type="button" value="3" onclick="dis('3')" /> </td>
                                            <td><input type="button" value="/" onclick="dis('/')" /> </td>
                                        </tr>
                                        <tr>
                                            <td><input type="button" value="4" onclick="dis('4')" /> </td>
                                            <td><input type="button" value="5" onclick="dis('5')" /> </td>
                                            <td><input type="button" value="6" onclick="dis('6')" /> </td>
                                            <td><input type="button" value="-" onclick="dis('-')" /> </td>
                                        </tr>
                                        <tr>
                                            <td><input type="button" value="7" onclick="dis('7')" /> </td>
                                            <td><input type="button" value="8" onclick="dis('8')" /> </td>
                                            <td><input type="button" value="9" onclick="dis('9')" /> </td>
                                            <td><input type="button" value="+" onclick="dis('+')" /> </td>
                                        </tr>
                                        <tr>
                                            <td><input type="button" value="." onclick="dis('.')" /> </td>
                                            <td><input type="button" value="0" onclick="dis('0')" /> </td>
                                            <!-- solve function call function solve to evaluate value -->
                                            <td><input type="button" value="=" onclick="solve()" /> </td>
                                            <td><input type="button" value="*" onclick="dis('*')" /> </td>
                                        </tr>
                                    </table>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                                <a href="{{ route('method.index') }}" class="btn btn-default">Trở về</a>
                                <button type="submit" class="btn green-meadow radius">Thiết lập</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
    <script>
        let textTu = `<div class="cluster">
                            <div class="col-lg-1">
                                <select name="methodTuSo[]">
                                    <option value="0">+</option>
                                    <option value="1">-</option>
                                    <option value="2">*</option>
                                    <option value="3">/</option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <input type="text" class="form-control " min="1" max="5" name="nameNumerator[]" required>
                            </div>
                        </div>`
        let numTu = `<div class="cluster">
                            <div class="col-lg-1">
                                    <select name="methodTuSo[]">
                                            <option value="0">+</option>
                                            <option value="1">-</option>
                                            <option value="2">*</option>
                                            <option value="3">/</option>
                                        </select>
                            </div>
                            <div class="col-lg-3">
                                <input type="number" class="form-control numNumerator" min="1" value="1" name="numNumerator[]" required>
                            </div>
                        </div>`
        $('#addTuso').click(function () {
            $('#addMoreTuSoText').append(textTu);
            $('#addMoreTuSoNum').append(numTu);
        });

        $('#removeTuso').click(function () {
            $('#addMoreTuSoText').find('div:last-child.cluster').remove();
            $('#addMoreTuSoNum').find('div:last-child.cluster').remove();
        })

    </script>
    <script>
        let clusterMauso = `<div class="cluster">
                                <div class="col-lg-1">
                                    <select name="methodMauSo[]">
                                        <option value="0">+</option>
                                        <option value="1">-</option>
                                        <option value="2">*</option>
                                        <option value="3">/</option>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <input type="text" class="form-control" min="1" name="nameDenominator[]" required>
                                </div>
                            </div>`
        let clusterMausoNum = `<div class="cluster">
                                    <div class="col-lg-1">
                                        <select name="methodMauSo[]">
                                            <option value="0">+</option>
                                            <option value="1">-</option>
                                            <option value="2">*</option>
                                            <option value="3">/</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="number" class="form-control" min="1" value="1" name="numDenominator[]" required>
                                    </div>
                                </div>`
        $('#addMauso').click(function () {
            $('#addMoreMauso').append(clusterMauso);
            $('#addMoreMausoNum').append(clusterMausoNum);
        });
        $('#removeMauso').click(function () {
            $('#addMoreMauso').find('div:last-child.cluster').remove();
            $('#addMoreMausoNum').find('div:last-child.cluster').remove();
        })

    </script>
    <script>
            //function that display value
            function dis(val)
            {
                document.getElementById("result").value+=val
            }

            //function that evaluates the digit and return result
            function solve()
            {
                let x = document.getElementById("result").value
                let y = eval(x)
                document.getElementById("result").value = y
            }

            //function that clear the display
            function clr()
            {
                document.getElementById("result").value = ""
            }
         </script>
</div>
@endsection
