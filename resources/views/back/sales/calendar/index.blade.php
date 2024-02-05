@extends('back.layouts.admin')

@push('css_before')
@endpush

@section('content')

    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Calendar</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @include('back.layouts.partials.session')

        <div class="col-sm-12">
            <div class="card">
                <div class="card-body pc-component">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home" role="tab"
                               aria-controls="pills-home" aria-selected="true">List view</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile" role="tab"
                               aria-controls="pills-profile" aria-selected="false">Calendar view</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="row mt-5">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Customer Name</th>
                                                <th>Contact</th>
                                                <th>Orders</th>
                                                <th>Spent</th>
                                                <th>Status</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>179</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-auto">
                                                            <img src="../assets/images/user/avatar-1.jpg" alt="user-image"
                                                                 class="wid-40 rounded-circle">
                                                        </div>
                                                        <div class="col">
                                                            <h6 class="mb-0">Addie Bass</h6>
                                                            <p class="text-muted f-12 mb-0">mareva@gmail.com</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>+1 (247) 849-6968</td>
                                                <td>45</td>
                                                <td>$7,634 </td>
                                                <td><span class="badge bg-light-success rounded-pill f-12">Relationship</span> </td>
                                                <td class="text-center">
                                                    <ul class="list-inline me-auto mb-0">
                                                        <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="View">
                                                            <a href="#" class="avtar avtar-xs btn-link-secondary btn-pc-default" data-bs-toggle="modal"
                                                               data-bs-target="#customer-modal">
                                                                <i class="ti ti-eye f-18"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                                            <a href="#" class="avtar avtar-xs btn-link-success btn-pc-default" data-bs-toggle="modal"
                                                               data-bs-target="#customer-edit_add-modal">
                                                                <i class="ti ti-edit-circle f-18"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Delete">
                                                            <a href="#" class="avtar avtar-xs btn-link-danger btn-pc-default">
                                                                <i class="ti ti-trash f-18"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>60</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-auto">
                                                            <img src="../assets/images/user/avatar-2.jpg" alt="user-image"
                                                                 class="wid-40 rounded-circle">
                                                        </div>
                                                        <div class="col">
                                                            <h6 class="mb-0">Agnes McGee</h6>
                                                            <p class="text-muted f-12 mb-0">heba@gmail.com</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>+1 (247) 849-6968</td>
                                                <td>42</td>
                                                <td>$3,742</td>
                                                <td><span class="badge bg-light-primary rounded-pill f-12">Single</span> </td>
                                                <td class="text-center">
                                                    <ul class="list-inline me-auto mb-0">
                                                        <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="View">
                                                            <a href="#" class="avtar avtar-xs btn-link-secondary btn-pc-default" data-bs-toggle="modal"
                                                               data-bs-target="#customer-modal">
                                                                <i class="ti ti-eye f-18"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Edit">
                                                            <a href="#" class="avtar avtar-xs btn-link-success btn-pc-default" data-bs-toggle="modal"
                                                               data-bs-target="#customer-edit_add-modal">
                                                                <i class="ti ti-edit-circle f-18"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item align-bottom" data-bs-toggle="tooltip" title="Delete">
                                                            <a href="#" class="avtar avtar-xs btn-link-danger btn-pc-default">
                                                                <i class="ti ti-trash f-18"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- [ sample-page ] end -->
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="row mt-5">
                                <div class="col-sm-12">
                                    <div id="calendar" class="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('modals')
    <div class="modal fade" id="calendar-modal" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="calendar-modal-title f-w-600 text-truncate">Modal title</h3>
                    <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default" data-bs-dismiss="modal">
                        <i class="ti ti-x f-20"></i>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-xs bg-light-secondary">
                                <i class="ti ti-heading f-20"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1"><b>Title</b></h5>
                            <p class="pc-event-title text-muted"></p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-xs bg-light-warning">
                                <i class="ti ti-map-pin f-20"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1"><b>Venue</b></h5>
                            <p class="pc-event-venue text-muted"></p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-xs bg-light-danger">
                                <i class="ti ti-calendar-event f-20"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1"><b>Date</b></h5>
                            <p class="pc-event-date text-muted"></p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-xs bg-light-primary">
                                <i class="ti ti-file-text f-20"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1"><b>Description</b></h5>
                            <p class="pc-event-description text-muted"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <ul class="list-inline me-auto mb-0">
                        <li class="list-inline-item align-bottom">
                            <a href="#" id="pc_event_remove" class="avtar avtar-s btn-link-danger btn-pc-default w-sm-auto" data-bs-toggle="tooltip"
                               title="Delete">
                                <i class="ti ti-trash f-18"></i>
                            </a>
                        </li>
                        <li class="list-inline-item align-bottom">
                            <a href="#" id="pc_event_edit" class="avtar avtar-s btn-link-success btn-pc-default" data-bs-toggle="tooltip"
                               title="Edit">
                                <i class="ti ti-edit-circle f-18"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="flex-grow-1 text-end">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end cal-event-offcanvas" tabindex="-1" id="calendar-add_edit_event">
        <div class="offcanvas-header">
            <h3 class="f-w-600 text-truncate">Add Events</h3>
            <a href="#" class="avtar avtar-s btn-link-danger btn-pc-default" data-bs-dismiss="offcanvas">
                <i class="ti ti-x f-20"></i>
            </a>
        </div>
        <div class="offcanvas-body">
            <form id="pc-form-event" novalidate>
                <div class="form-group">
                    <label class="form-label">Title</label>
                    <input type="email" class="form-control" id="pc-e-title" placeholder="Enter event title" autofocus>
                </div>
                <div class="form-group">
                    <label class="form-label">Venue</label>
                    <input type="email" class="form-control" id="pc-e-venue" placeholder="Enter event venue">
                </div>
                <div class="form-group m-0">
                    <input type="hidden" class="form-control" id="pc-e-sdate">
                    <input type="hidden" class="form-control" id="pc-e-edate">
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" placeholder="Enter event description" rows="3"
                              id="pc-e-description"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Type</label>
                    <select class="form-select" id="pc-e-type">
                        <option value="empty" selected>Type</option>
                        <option value="event-primary">Primary</option>
                        <option value="event-secondary">Secondary</option>
                        <option value="event-success">Success</option>
                        <option value="event-danger">Danger</option>
                        <option value="event-warning">Warning</option>
                        <option value="event-info">Info</option>
                    </select>
                </div>
                <div class="row justify-content-between">
                    <div class="col-auto"><button type="button" class="btn btn-link-danger btn-pc-default" data-bs-dismiss="offcanvas"><i
                                    class="align-text-bottom me-1 ti ti-circle-x"></i> Close</button></div>
                    <div class="col-auto">
                        <button id="pc_event_add" type="button" class="btn btn-secondary" data-pc-action="add">
                            <span id="pc-e-btn-text"><i class="align-text-bottom me-1 ti ti-calendar-plus"></i> Add</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endpush

@push('js_after')
    <!-- calender js -->
    <script src="{{ asset('assets/back/js/plugins/index.global.min.js') }}"></script>
    <!-- Sweet Alert -->
    <script src="{{ asset('assets/back/js/plugins/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/back/js/pages/calendar.js') }}"></script>
    <script>
        $(() => {

        })
    </script>
@endpush
