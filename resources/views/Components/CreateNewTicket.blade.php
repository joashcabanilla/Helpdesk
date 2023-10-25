<div class="container-fluid">
    <div class="card card-primary card-outline elevation-2 p-3 col-lg-8 col-md-10 col-sm-12">

        <div class="row">
            <div class="col-12">
                <a class="btn btn-primary btn-sm font-weight-bold float-right" id="backBtn"></a>
            </div>
        </div>

        <form method="POST" enctype="multipart/form-data">
            <input type="file" class="d-none" name="attachImage" accept="image/jpeg, image/png, image/jpg" multiple>

            <div class="row mt-3">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="category">Concern Category</label>
                        <select class="form-control select2bs4" data-placeholder="Select Category" id="category" name="category" style="width: 100%;">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
    
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <select class="form-control select2bs4" data-placeholder="Select Subject" id="subject" name="subject" disabled style="width: 100%;"> 
                            <option value=""></option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <p class="font-weight-bold float-left mt-1 mb-0 mr-1">Attachments (0)</p>
                    <a class="btn btn-sm btn-light">File Name1 <i class="far fa-times-circle text-danger"></i></a>
                    <a class="btn btn-sm btn-light">File Name2 <i class="far fa-times-circle text-danger"></i></a>
                    <a class="btn btn-sm btn-light">File Name3 <i class="far fa-times-circle text-danger"></i></a>
                    <div class="float-right">
                        <a class="btn btn-sm btn-light font-weight-bold" id="deleteImage" title="delete all"><i class="fas fa-trash"></i></a>
                        <a class="btn btn-sm btn-light font-weight-bold" id="addImage"  title="add Image"><i class="fas fa-plus"></i></a>
                    </div>
                </div>
            </div>

            <div class="row attachmentContainer">
                <div class="col-lg-2 col-md-3 col-sm-12 p-1">
                    <div class="img-fluid elevation-2 carouselImage">
                        <img class="carouselSetImage" alt="attachment image"  width="100" height="100" src="{{asset('image/logo.png')}}"/>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-12 p-1">
                    <div class="img-fluid elevation-2 carouselImage">
                        <img class="carouselSetImage" alt="attachment image" width="100" height="100" src="{{asset('image/noimage-black.jpg')}}"/>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-sm-12 p-1">
                    <div class="img-fluid elevation-2 carouselImage">
                        <img class="carouselSetImage" alt="attachment image" width="100" height="100" src="{{asset('image/noimage-black.jpg')}}"/>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>