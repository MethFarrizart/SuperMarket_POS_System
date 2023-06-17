<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- Category -->
    <div class="row mt-3" id="slide2">
        <div class="col-12">
            <div class="bg-white p-4 shadow border" style="border-radius: 20px;">
                <p style="font-weight: bold; text-decoration:overline" class="fs-5">
                    Category List
                </p>

                <div class="d-flex gap-2 justify-content-end three-btn">
                    <button class="btn p-3 btn-1 text-white" data-bs-toggle="modal" data-bs-target="#addcate">Add Category</button>
                </div>

                <table class="table table-hover mt-3">
                    <thead>
                        <tr class="mt-4 text-white text-center h5" style="background-color: rgb(13, 77, 141); line-height: 50px;">
                            <td>CategoryID</td>
                            <td>Category Name</td>
                            <td>Action</td>
                        </tr>
                    </thead>

                    <?php
                    $qry_cate = $con->query("SELECT * FROM category");
                    while ($cate_row = $qry_cate->fetch_assoc()) {
                    ?>
                        <tbody>
                            <tr class="text-center h6" style="line-height: 50px;">
                                <td><?= $cate_row['CategoryID'] ?> </td>
                                <td><?= $cate_row['CategoryName'] ?> </td>
                                <td align="center" class="pt-1">
                                    <button type="button" class="btn text-white px-4 p-2" style="background-color: #1D9A29;" data-bs-toggle="offcanvas" data-bs-target="#editcate-<?= $cate_row['CategoryID'] ?>" aria-controls="editcate">
                                        <i class="fa-solid fa-pen-to-square" style="color: yellow;"></i>
                                        Edit
                                    </button>

                                    <button type="button" class="btn text-white px-4 p-2 " style="background-color: red;" data-bs-toggle="offcanvas" data-bs-target="#deletecate-<?= $cate_row['CategoryID'] ?>" aria-controls="deletecate">
                                        <i class="fa-sharp fa-solid fa-trash" style="color: yellow;"></i>
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>

                        <!-- Delete Category -->
                        <div class="offcanvas offcanvas-top w-100" tabindex="-1" id="deletecate-<?= $cate_row['CategoryID'] ?>" aria-labelledby="deleteLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="deleteLabel">Delete Category</h5>
                                <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="offcanvas" aria-label="Close" style="cursor: grab;">
                            </div>
                            <div class="offcanvas-body bg-warning">
                                <form action="" method="get">
                                    <h3> Are You Sure?</h3>

                                    <div class="col-12">
                                        <input type="text" class="form-control" name="del_cateid" value="<?= $cate_row['CategoryID'] ?>" readonly>
                                    </div>

                                    <div class="modal-footer mt-5">
                                        <button type="submit" class="btn btn-danger" name="delete_cate">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <!-- Update Category -->
                        <div class="offcanvas offcanvas-end w-25" tabindex="-1" id="editcate-<?= $cate_row['CategoryID'] ?>" aria-labelledby="editLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="editLabel">Update Category</h5>
                                <img src="https://cdn1.iconfinder.com/data/icons/everyday-5/64/cross_delete_stop_x_denied_stopped-256.png" width="50px" height="50px" data-bs-dismiss="offcanvas" aria-label="Close" style="cursor: grab;">
                            </div>
                            <div class="offcanvas-body bg-primary">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="row gap-4">
                                        <div class="col-12">
                                            <label class="control-label">Category_ID: </label>
                                            <input type="text" name="check_cateid" value=" <?= $cate_row['CategoryID'] ?>" class="form-control" readonly>
                                        </div>

                                        <div class="col-12">
                                            <label class="control-label">Category Name: </label>
                                            <input type="text" name="upd_catename" value=" <?= $cate_row['CategoryName'] ?>" class="form-control">
                                        </div>

                                    </div>

                                    <div class="modal-footer mt-5 gap-2">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="offcanvas">Leave</button>
                                        <button type="submit" name="upd_cate" class="btn btn-success">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>