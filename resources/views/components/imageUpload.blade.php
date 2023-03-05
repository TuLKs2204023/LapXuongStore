<div class="form-group row mb-3 myFilesUpload">
    <label for="photo" class="col-sm-2 col-form-label">Image</label>
    <div class="col-sm-10">
        <div class="input-group hdtuto control-group lst increment">
            <div class="list-input-hidden-upload">
                <input type="file" name="photos[]" id="file_upload" multiple
                    class="myfrm form-control hidden">
            </div>
            <div class="input-group-btn">
                <button class="btn btn-success btn-add-image" type="button">
                    <i class="fldemo glyphicon glyphicon-plus"></i>
                    + Add image
                </button>
            </div>
        </div>
        <div class="list-images">
            @if ($list_images)
                @foreach ($list_images as $img)
                    <div class="box-image">
                        <input type="hidden" name="images_edited[]" value="{{ $img->url }}"
                            id="img-{{ $img->id }}">
                        <img src="{{ asset('images/' . $img->url) }}" class="picture-box">
                        <div class="wrap-btn-delete"><span data-id="img-{{ $img->id }}"
                                class="btn-delete-image">x</span></div>
                    </div>
                @endforeach
                <input type="hidden" name="id" value="{{ $product->id ?? $manufacture->id }}">
            @endif
        </div>
    </div>
</div>
