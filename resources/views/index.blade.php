@include('header', ['title' => 'Data Transfer App'])
<!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Upload Files</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('files.store')}}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">File Path Name</label>
                            <input type="text" name="name" class="form-control has-validation @error('name') is-invalid @enderror" id="name" aria-describedby="emailHelp" required>
                            @error('name')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Input Files</label>
                            <input class="form-control has-validation @error('name') is-invalid @enderror" name="files[]" type="file" id="file" multiple required>
                            @error('files[]')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <main class="container">
        <section class="py-3">
            <div class="container-fluid">
                <h2 class="text-center text-dark fw-bold">Data Transfer App</h2>
                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    + Upload File
                </button>
                <table class="table table-striped z-3 mt-3">
                    <thead>
                    <tr>
                        <th scope="col" class="text-nowrap">File Path</th>
                        <th scope="col" class="text-nowrap"></th>
                        <th scope="col" class="text-nowrap"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($files as $file)
                        <tr>
                            <th class="text-wrap fw-normal"><a href="{{route('files.show', ['file' => $file->id])}}" class="text-decoration-none">{{$file->name . " "}} &#x2935;</a></th>
                            <td class="text-nowrap">🧑‍💼 Ali</td>
                            <td class="text-nowrap">🕓{{$file->created_at->since()}}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                        <li><button class="dropdown-item" type="button">⬇️ Download</button></li>
                                        <li>
                                            <form action="{{route('files.destroy', ['file' => $file->id])}}?delete={{$file->id}}" method="post">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="dropdown-item bg-danger text-white">❕Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th colspan="4" class="text-center fw-semibold">No files uploaded.</th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{$files->links()}}
            </div>
        </section>
    </main>
@include('footer')
