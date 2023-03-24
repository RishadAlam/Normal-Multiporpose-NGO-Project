@extends('layouts.main')

@push('title')
    {{ __('Create New Client') }}
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a>{{ __('Registrations') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active">{{ __('Create New Client') }}</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        <div class="card rounded rounded-3">
            <div class="card-header py-5 text-center">
                <b class="text-uppercase" style="font-size: 22px;">Create Client Profile with a Saving Account</b>
            </div>
            <form id="client_registration" class="validation-form" action="{{ Route('registration.newCustomer.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <!-- START: Registration Form -->
                    <div class="row">
                        <!-- Account Information -->
                        <div class="col-md-12 mb-3 rounded-3 shadow-inner py-3 form-head">
                            <b class="text-uppercase">Account Information</b>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="volume" class="form-label">Volume <span class="text-danger">*</span></label>
                                <select id="volume" name="volume" data-placeholder="Select your favorite actors"
                                    class="select w-full" required>
                                    <option disabled selected>Choose Volume...</option>
                                    @foreach ($volumes as $volume)
                                        <option value="{{ $volume->id }}">{{ $volume->name }}</option>
                                    @endforeach
                                </select>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger volume_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="center" class="form-label">Center <span class="text-danger">*</span></label>
                                <select id="center" name="center" data-placeholder="Select your favorite actors"
                                    class="select w-full" required>
                                    <option disabled selected>First Choose volume...</option>
                                </select>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger center_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="accNo" class="form-label">Account No. <span
                                        class="text-danger">*</span></label>
                                <input id="accNo" type="number" name="accNo" class="form-control" placeholder="xxxx"
                                    required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger accNo_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="Officers" class="form-label">Registration Officer <span
                                        class="text-danger">*</span></label>
                                <select id="Officers" name="officers" data-placeholder="Select your favorite actors"
                                    class="select w-full" required>
                                    @if (auth()->user()->can('Officer Selection in Account Registration'))
                                        <option disabled selected>Choose Registration Officer...</option>
                                        @foreach ($officers as $officer)
                                            <option value="{{ $officer->id }}">{{ $officer->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="{{ auth()->user()->id }}" selected>{{ auth()->user()->name }}
                                        </option>
                                    @endif
                                </select>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger officers_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="savingType" class="form-label">Saving Type <span
                                        class="text-danger">*</span></label>
                                <select id="savingType" name="savingType" data-placeholder="Select your favorite actors"
                                    class="select w-full">
                                    <option disabled selected>Choose Saving Type...</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger savingType_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="deposit" class="form-label">Deposit
                                    <span class="text-danger">*</span></label>
                                <input id="deposit" type="number" name="deposit" class="form-control" placeholder="xxxx"
                                    required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger deposit_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="startDate" class="form-label">Start date <span
                                        class="text-danger">*</span></label>
                                <input id="startDate" name="startDate" class="datepicker form-control"
                                    data-single-mode="true" required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger startDate_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="installment" class="form-label">Duration date <span
                                        class="text-danger">*</span></label>
                                <input id="Duration" name="duration" class="datepicker form-control"
                                    data-single-mode="true" required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger duration_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="installment" class="form-label">Installment
                                    <span class="text-danger">*</span></label>
                                <input id="installment" type="number" name="installment"
                                    class="form-control @error('installment') is-invalid @enderror" placeholder="xxxx"
                                    required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger installment_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="totalWithoutInterest" class="form-label">Total except Interest
                                    <span class="text-danger">*</span></label>
                                <input id="totalWithoutInterest" type="number" name="totalWithoutInterest"
                                    class="form-control" placeholder="xxxx" required readonly>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger totalWithoutInterest_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="interest" class="form-label">Interest (%)
                                    <span class="text-danger">*</span></label>
                                <input id="interest" type="number" name="interest" class="form-control"
                                    placeholder="xxxx" required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger interest_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="totalWithInterest" class="form-label">Total include Interest
                                    <span class="text-danger">*</span></label>
                                <input id="totalWithInterest" type="number" name="totalWithInterest"
                                    class="form-control" placeholder="xxxx" required readonly>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger totalWithInterest_error"></span>
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div class="col-md-12 my-3 rounded-3 shadow-inner py-3 form-head">
                            <b class="text-uppercase">Personal Information</b>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input id="name" type="text" name="name" class="form-control"
                                    placeholder="Name" required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="husbandName" class="form-label">Husband/father's Name <span
                                        class="text-danger">*</span></label>
                                <input id="husbandName" type="text" name="husbandName"
                                    class="form-control @error('husbandName') is-invalid @enderror"
                                    placeholder="Husband/father's Name" required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger husbandName_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="motherName" class="form-label">Mother's
                                    Name <span class="text-danger">*</span></label>
                                <input id="motherName" type="text" name="motherName" class="form-control"
                                    placeholder="Mother's Name" required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger motherName_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="dob" class="form-label">Birth
                                    Reg.No/Voter ID No <span class="text-danger">*</span></label>
                                <input id="nid" type="number" name="nid" class="form-control"
                                    placeholder="xxx-xxxx-xxx" maxlength="20" required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger nid_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="academyQualify" class="form-label">Academy
                                    Qualifications</label>
                                <input id="academyQualify" type="text" name="qualifications" class="form-control"
                                    placeholder="Academy Qualifications" maxlength="20">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="dob" class="form-label">Date of
                                    Birth <span class="text-danger">*</span></label>
                                <input id="dob" name="dob" class="datepicker form-control"
                                    data-single-mode="true" required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger dob_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="dob" class="form-label">Religion
                                    <span class="text-danger">*</span></label>
                                <div class="border p-3 rounded-3">
                                    <div class="form-check d-inline-block me-2">
                                        <input id="Islam" class="form-check-input" type="radio" name="religion"
                                            value="Islam">
                                        <label class="form-check-label" for="Islam">Islam</label>
                                    </div>
                                    <div class="form-check d-inline-block me-2 mt-2 mt-sm-0">
                                        <input id="Hindu" class="form-check-input" type="radio" name="religion"
                                            value="Hindu">
                                        <label class="form-check-label" for="Hindu">Hindu</label>
                                    </div>
                                    <div class="form-check d-inline-block me-2 mt-2 mt-sm-0">
                                        <input id="Buddha" class="form-check-input" type="radio" name="religion"
                                            value="Buddha">
                                        <label class="form-check-label" for="Buddha">Buddha</label>
                                    </div>
                                    <div class="form-check d-inline-block me-2 mt-2 mt-sm-0">
                                        <input id="Christian" class="form-check-input" type="radio"
                                            name="religion"value="Christian"> <label class="form-check-label"
                                            for="Christian">Christian</label>
                                    </div>
                                </div>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger religion_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="dob" class="form-label">Occupation
                                    <span class="text-danger">*</span></label>
                                <div class="border p-3 rounded-3">
                                    <div class="form-check me-2 d-inline-block">
                                        <input id="Business" class="form-check-input" type="radio" name="occupation"
                                            value="Business">
                                        <label class="form-check-label" for="Business">Business</label>
                                    </div>
                                    <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                        <input id="Jobs" class="form-check-input" type="radio" name="occupation"
                                            value="Jobs">
                                        <label class="form-check-label" for="Jobs">Jobs</label>
                                    </div>
                                    <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                        <input id="worker" class="form-check-input" type="radio" name="occupation"
                                            value="worker">
                                        <label class="form-check-label" for="worker">Worker</label>
                                    </div>
                                    <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                        <input id="Driver" class="form-check-input" type="radio" name="occupation"
                                            value="Driver">
                                        <label class="form-check-label" for="Driver">Driver</label>
                                    </div>
                                    <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                        <input id="Rickshaw-driver" class="form-check-input" type="radio"
                                            name="occupation" value="Rickshaw-driver">
                                        <label class="form-check-label" for="Rickshaw-driver">Rickshaw Driver</label>
                                    </div>
                                    <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                        <input id="housewife" class="form-check-input" type="radio"
                                            name="occupation"value="housewife">
                                        <label class="form-check-label" for="housewife">Housewife</label>
                                    </div>
                                    <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                        <input id="Others" class="form-check-input" type="radio" name="occupation"
                                            value="Others">
                                        <label class="form-check-label" for="Others">Others</label>
                                    </div>
                                </div>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger occupation_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="dob" class="form-label">Gender
                                    <span class="text-danger">*</span></label>
                                <div class="border p-3 rounded-3 @error('gender') is-invalid @enderror">
                                    <div class="form-check me-2 d-inline-block">
                                        <input id="Male" class="form-check-input" type="radio" name="gender"
                                            value="Male">
                                        <label class="form-check-label" for="Male">Male</label>
                                    </div>
                                    <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                        <input id="Female" class="form-check-input" type="radio" name="gender"
                                            value="Female">
                                        <label class="form-check-label" for="Female">Female</label>
                                    </div>
                                    <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                        <input id="others" class="form-check-input" type="radio" name="gender"
                                            value="others">
                                        <label class="form-check-label" for="others">others</label>
                                    </div>
                                </div>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger gender_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="mobile" class="form-label">Mobile <span
                                        class="text-danger">*</span></label>
                                <input id="mobile" type="number" name="mobile" class="form-control"
                                    placeholder="01xxx-xxxxxxx" maxlength="11" minlength="11" required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger mobile_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="share" class="form-label">Share <span class="text-danger">*</span></label>
                                <input id="share" type="number" name="share" class="form-control"
                                    value="0">

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger share_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="client_image" class="form-label">Client Image <span
                                        class="text-danger">*</span></label>
                                <div class="w-52 @error('client_image') is-invalid @enderror">
                                    <div
                                        class="border-2 border-dashed shadow-sm border-gray-200 dark-border-dark-5 rounded-2 p-5">
                                        <div class="h-40 position-relative image-fit cursor-pointer zoom-in mx-auto">
                                            <img class="rounded-2" id="preview_client_image" alt="client_image"
                                                src="{{ asset('storage/placeholder/profile.png') }}">
                                        </div>
                                        <div class="mx-auto position-relative mt-5">
                                            {{-- <button type="button" class="btn btn-primary w-full">Change Logo</button> --}}
                                            <label for="client_image" class="btn btn-primary form-control"
                                                style="font-size: 24px"><i class='bx bx-camera'></i></label>
                                            <input type="file" id="client_image" name="client_image"
                                                class="w-full h-full top-0 start-0 position-absolute opacity-0 cursor-pointer"
                                                required onchange="getImagePreview(event, 'preview_client_image')"
                                                accept="image/*">
                                        </div>
                                    </div>
                                </div>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger client_image_error"></span>
                            </div>
                        </div>


                        <!-- Present Address -->
                        <div class="present_address">
                            <div class="row">
                                <div class="col-md-12 my-3 rounded-3 shadow-inner py-3 form-head">
                                    <b class="text-uppercase">Present Address</b>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="input-form">
                                        <label for="house" class="form-label">House/Appertment/Road <span
                                                class="text-danger">*</span></label>
                                        <input id="house" type="text" name="house" class="form-control"
                                            placeholder="House/Appertment/Road" maxlength="100" required>

                                        <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger house_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-form">
                                        <label for="village" class="form-label">Village <span
                                                class="text-danger">*</span></label>
                                        <input id="village" type="text" name="village" class="form-control"
                                            placeholder="Village" maxlength="100" required>

                                        <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger village_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-form">
                                        <label for="postOffice" class="form-label">Post Office </label>
                                        <input id="postOffice" type="text" name="postOffice" class="form-control"
                                            placeholder="Post Office" maxlength="100">

                                        <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger postOffice_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-form">
                                        <label for="postcodes" class="form-label">Post Code <span
                                                class="text-danger">*</span></label>
                                        <select id="postcodes" name="postcodes" class="form-control select">
                                            <option disabled selected>First Choose a District</option>
                                        </select>

                                        <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger postcodes_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-form">
                                        <label for="upazilas" class="form-label">Police Station <span
                                                class="text-danger">*</span></label>
                                        <input id="upazilas" type="text" name="upazilas" class="form-control"
                                            placeholder="Police Station" maxlength="100" required>

                                        <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger upazilas_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-form">
                                        <label for="districts" class="form-label">Districts <span
                                                class="text-danger">*</span></label>
                                        <select id="districts" name="districts" class="form-control select">
                                            <option disabled selected>First Choose a Division</option>
                                        </select>

                                        <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger districts_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-form">
                                        <label for="divisions" class="form-label">Divisions <span
                                                class="text-danger">*</span></label>
                                        <select id="divisions" name="divisions" class="form-control select">
                                        </select>

                                        <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger divisions_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Permanent Address -->
                        <div class="permanent_address">
                            <div class="row">
                                <div class="col-md-12 my-3 rounded-3 shadow-inner py-3 form-head">
                                    <b class="text-uppercase">Permanent Address</b>
                                </div>
                                <div class="col-md-12 text-end">
                                    <label for="client_address_switch" class="form-label cursor-pointer">If Permanent
                                        Address same as Present Address</label>
                                    <input id="client_address_switch" class="form-check-input" type="checkbox"
                                        value="1">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="input-form">
                                        <label for="p_house" class="form-label">House/Appertment/Road <span
                                                class="text-danger">*</span></label>
                                        <input id="p_house" type="text" name="p_house" class="form-control"
                                            placeholder="House/Appertment/Road" maxlength="100" required>

                                        <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger p_house_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-form">
                                        <label for="p_village" class="form-label">Village
                                            <span class="text-danger">*</span></label>
                                        <input id="p_village" type="text" name="p_village" class="form-control"
                                            placeholder="Village" maxlength="100" required>

                                        <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger p_village_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-form">
                                        <label for="p_postOffice" class="form-label">Post Office </label>
                                        <input id="p_postOffice" type="text" name="p_postOffice" class="form-control"
                                            placeholder="Post Office" maxlength="100">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-form">
                                        <label for="p_postcodes" class="form-label">Post Code <span
                                                class="text-danger">*</span></label>
                                        <select id="p_postcodes" name="p_postcodes" class="form-control select">
                                            <option disabled selected>First Choose a District</option>
                                        </select>

                                        <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger p_postcodes_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-form">
                                        <label for="p_upazilas" class="form-label">Police Station <span
                                                class="text-danger">*</span></label>
                                        <input id="p_upazilas" type="text" name="p_upazilas" class="form-control"
                                            placeholder="Police Station" maxlength="100" required>

                                        <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger p_upazilas_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-form">
                                        <label for="p_districts" class="form-label">Districts <span
                                                class="text-danger">*</span></label>
                                        <select id="p_districts" name="p_districts" class="form-control select">
                                            <option disabled selected>First Choose a Division</option>
                                        </select>

                                        <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger p_districts_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="input-form">
                                        <label for="p_divisions" class="form-label">Divisions <span
                                                class="text-danger">*</span></label>
                                        <select id="p_divisions" name="p_divisions" class="form-control select">
                                        </select>

                                        <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger p_divisions_error"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Nominee Section -->
                        <div class="nominee_sections">
                            <div class="row">
                                <div class="col-md-12 my-3 rounded-3 shadow-inner py-3 form-head">
                                    <b class="text-uppercase">Nominee Informations - 1</b>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-form">
                                        <label for="name_1" class="form-label">Name <span
                                                class="text-danger">*</span></label>
                                        <input id="name_1" type="text" name="name_1" class="form-control"
                                            placeholder="Name" required>

                                        <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger name_1_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-form">
                                        <label for="dob_1" class="form-label">Date of
                                            Birth <span class="text-danger">*</span></label>
                                        <input id="dob_1" name="dob_1" class="datepicker form-control"
                                            data-single-mode="true" required>

                                        <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger dob_1_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-form">
                                        <label for="segment_1" class="form-label">Segment (%)</label>
                                        <input id="segment_1" type="number" name="segment_1" class="form-control"
                                            placeholder="%">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-form">
                                        <label for="relation_1" class="form-label">Relation <span
                                                class="text-danger">*</span></label>
                                        <select id="relation_1" name="relation_1" class="form-control select">
                                            <option disabled selected>Choose Relation...</option>
                                            <option value="Husband/Wife">Husband/Wife</option>
                                            <option value="Brother/sister">Brother/sister</option>
                                            <option value="Father/Daughter">Father/Daughter</option>
                                            <option value="Mother/Daughter">Mother/Daughter</option>
                                            <option value="Father/Son">Father/Son</option>
                                            <option value="Mother/Son">Mother/Son</option>
                                            <option value="Sister/Sister">Sister/Sister</option>
                                            <option value="Brother/Brother">Brother/Brother</option>
                                            <option value="Others">Others</option>
                                        </select>

                                        <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger relation_1_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-form">
                                        <label for="nomee_image_1" class="form-label">Nominee Image</label>
                                        <div class="w-52">
                                            <div
                                                class="border-2 border-dashed shadow-sm border-gray-200 dark-border-dark-5 rounded-2 p-5">
                                                <div
                                                    class="h-40 position-relative image-fit cursor-pointer zoom-in mx-auto">
                                                    <img class="rounded-2" id="preview_nominee_1_image"
                                                        alt="nomee_image_1"
                                                        src="{{ asset('storage/placeholder/profile.png') }}">
                                                </div>
                                                <div class="mx-auto position-relative mt-5">
                                                    {{-- <button type="button" class="btn btn-primary w-full">Change Logo</button> --}}
                                                    <label for="nomee_image_1" class="btn btn-primary form-control"
                                                        style="font-size: 24px"><i class='bx bx-camera'></i></label>
                                                    <input type="file" id="nomee_image_1" name="nomee_image_1"
                                                        class="w-full h-full top-0 start-0 position-absolute opacity-0 cursor-pointer"
                                                        onchange="getImagePreview(event, 'preview_nominee_1_image')"
                                                        accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="nominee_sections">
                            <div class="row">
                                <div class="col-md-12 my-3 rounded-3 shadow-inner py-3 form-head">
                                    <b class="text-uppercase">Nominee Informations - 2</b>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-form">
                                        <label for="name_2" class="form-label">Name <span
                                                class="text-danger">*</span></label>
                                        <input id="name_2" type="text" name="name_2" class="form-control"
                                            placeholder="Name">

                                        <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger name_2_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-form">
                                        <label for="dob_2" class="form-label">Date of
                                            Birth <span class="text-danger">*</span></label>
                                        <input id="dob_2" name="dob_2" class="datepicker form-control"
                                            data-single-mode="true">

                                        <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger dob_2_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-form">
                                        <label for="segment_2" class="form-label">Segment (%)</label>
                                        <input id="segment_2" type="number" name="segment_2" class="form-control"
                                            placeholder="%">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-form">
                                        <label for="relation_2" class="form-label">Relation <span
                                                class="text-danger">*</span></label>
                                        <select id="relation_2" name="relation_2" class="form-control select">
                                            <option disabled selected>Choose Relation...</option>
                                            <option value="Husband/Wife">Husband/Wife</option>
                                            <option value="Brother/sister">Brother/sister</option>
                                            <option value="Father/Daughter">Father/Daughter</option>
                                            <option value="Mother/Daughter">Mother/Daughter</option>
                                            <option value="Father/Son">Father/Son</option>
                                            <option value="Mother/Son">Mother/Son</option>
                                            <option value="Sister/Sister">Sister/Sister</option>
                                            <option value="Brother/Brother">Brother/Brother</option>
                                            <option value="Others">Others</option>
                                        </select>

                                        <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger relation_2_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-form">
                                        <label for="nomee_image_2" class="form-label">Nominee Image</label>
                                        <div class="w-52">
                                            <div
                                                class="border-2 border-dashed shadow-sm border-gray-200 dark-border-dark-5 rounded-2 p-5">
                                                <div
                                                    class="h-40 position-relative image-fit cursor-pointer zoom-in mx-auto">
                                                    <img class="rounded-2" id="preview_nominee_2_image"
                                                        alt="nomee_image_2"
                                                        src="{{ asset('storage/placeholder/profile.png') }}">
                                                </div>
                                                <div class="mx-auto position-relative mt-5">
                                                    {{-- <button type="button" class="btn btn-primary w-full">Change Logo</button> --}}
                                                    <label for="nomee_image_2" class="form-control btn btn-primary"
                                                        style="font-size: 24px"><i class='bx bx-camera'></i></label>
                                                    <input type="file" id="nomee_image_2" name="nomee_image_2"
                                                        class="w-full h-full top-0 start-0 position-absolute opacity-0 cursor-pointer"
                                                        onchange="getImagePreview(event, 'preview_nominee_2_image')"
                                                        accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Registration Form -->
                </div>
        </div>
        <div class="card-footer">
            <button id="form_submit" type="submit" class="btn btn-primary mt-5 w-full">Save</button>
        </div>
        </form>
    </div>
    </div>
@endsection

@section('customFunctions')
    /**
    * Choose Divisions
    */
    divisions("divisions")
    divisions("p_divisions")

    /**
    * Choose Districts
    */
    $('#divisions').on('change', function() {
    var division_id = $(this).find(':selected').data('id')
    districts('districts', division_id)
    })

    $('#p_divisions').on('change', function() {
    var division_id = $(this).find(':selected').data('id')
    districts('p_districts', division_id)
    })

    /**
    * Choose Upazila
    * Choose Post Codes
    */
    $('#districts').on('change', function() {
    var district_id = $(this).find(':selected').data('id')
    policePost('postcodes', district_id)
    })

    $('#p_districts').on('change', function() {
    var district_id = $(this).find(':selected').data('id')
    policePost('p_postcodes', district_id)
    })
@endsection

@section('customJS')
    <script>
        // For Preview
        function getImagePreview(event, path) {
            var image = URL.createObjectURL(event.target.files[0]);
            var imagediv = document.getElementById(path);
            imagediv.src = '';
            imagediv.src = image;
        }

        $(document).ready(function() {
            // Success Msg Show
            @if (session()->has('success'))
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: true,
                })
            @endif

            $("#installment").on("keyup", function() {
                totalValue();
            })

            $("#deposit").on("keyup", function() {
                totalValue();
            })

            $("#interest").on("keyup", function() {
                totalValue();
            })
            // Total Calculation
            function totalValue() {
                var installment = $("#installment").val();
                var deposit = $("#deposit").val();
                var interest = $("#interest").val();
                var ceil = Math.round(installment * deposit);
                var total = ceil;
                var total_int = ((total / 100) * interest);
                var total_with_int = Math.round(parseFloat(total) + parseFloat(total_int));
                $("#totalWithoutInterest").val(ceil);
                $("#totalWithInterest").val(total_with_int);
            }


            // Get Centers by ajax
            $("#volume").on('change', function() {
                var vol = $(this).val()
                var url = "{{ Route('registration.newCustomer.get.center', 'id') }}"
                url = url.replace('id', vol)

                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        if (data != '') {
                            var options = []
                            options[0] = '<option disabled selected>Choose Center...</option>'
                            $.each(data, function(key, value) {
                                options[++key] = '<option value="' + value.id + '">' +
                                    value.name + '</option>'
                            })
                        } else {
                            options = '<option disabled selected>No Records Found!</option>'
                        }

                        $('#center').html('')
                        $('#center').html(options)
                    },
                    error: function(data) {
                        console.table(data)
                    }
                })
            })

            // Address Past
            $("#client_address_switch").on("click", function() {
                if ($(this).is(':checked')) {
                    // Store Present Address
                    var house = $("#house").val()
                    var village = $("#village").val()
                    var postOffice = $("#postOffice").val()
                    var upazilas = $("#upazilas").val()
                    var divisions = $("#divisions").val()
                    var districts = $("#districts").val()
                    var postcodes = $("#postcodes").val()

                    $('#p_house').val(house)
                    $('#p_village').val(village)
                    $('#p_postOffice').val(postOffice)
                    $('#p_upazilas').val(upazilas)
                    $('#p_divisions').val(divisions).change()
                    setTimeout(() => {
                        $('#p_districts').val(districts).change()
                    }, 100);
                    setTimeout(() => {
                        $('#p_postcodes').val(postcodes).change()
                    }, 200);
                }
            })

            // Submit Form
            $('#client_registration').on('submit', function(e) {
                e.preventDefault()
                var formData = new FormData(this)
                var btn = $("#form_submit")

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'JSON',
                    beforeSend: function() {
                        btn.attr('disabled', true)
                        $("#overlayer").fadeIn()
                        $("#preloader").fadeIn()
                    },
                    success: function(data) {
                        $("#overlayer").fadeOut()
                        $("#preloader").fadeOut()
                        btn.attr('disabled', false)
                        if (data.errors) {
                            // Validation Message
                            Swal.fire({
                                position: 'top-center',
                                icon: 'error',
                                title: '<b class="text-danger">All fields are required!</b>',
                                showConfirmButton: false,
                                timer: 2000
                            })
                            // Validation Message Loop
                            $("span.text-danger").text('')
                            $.each(data.errors, function(key, value) {
                                $("span." + key + "_error").text(value[0])
                                $("input[name=" + key + "]").addClass('is-invalid')
                            })
                        } else if (data.success) {
                            // Success Msg Show
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: data.message,
                                showConfirmButton: true,
                            }).then((result) => {
                                location.reload()
                            })
                        } else {
                            // Error Msg Show
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: 'Loan Account registration unsuccessfull!',
                                showConfirmButton: true,
                            })
                        }
                    },
                    error: function(data) {
                        $("#overlayer").fadeOut()
                        $("#preloader").fadeOut()
                        btn.attr('disabled', false)
                        console.log(data)
                        // Error Msg Show
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Loan Account registration unsuccessfull!',
                            showConfirmButton: true,
                        })
                    }
                })
            })
        })
    </script>
@endsection
