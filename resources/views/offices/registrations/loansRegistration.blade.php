@extends('layouts.main')

@push('title')
    {{ __('Create New Loan Account') }}
@endpush

@section('breadcrumb')
    <a href="{{ Route('home') }}">{{ __('Dashboard') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a>{{ __('Registrations') }}</a>
    <i data-feather="chevron-right" class="breadcrumb__icon"></i>
    <a class="breadcrumb--active">{{ __('Create New Loan Account') }}</a>
@endsection

@section('main_content')
    <div class="g-col-12 mt-3">
        <div class="card rounded rounded-3">
            <div class="card-header py-5 text-center">
                <b class="text-uppercase" style="font-size: 22px;">Create New Loan Account</b>
            </div>
            <form id="loan_registration" class="validation-form">
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
                                <label for="accNo" class="form-label">Account No.
                                    <span class="text-danger">*</span></label>
                                <select id="accNo" name="accNo" data-placeholder="Select your favorite actors"
                                    class="select w-full" required>
                                    <option disabled selected>Choose Account...</option>
                                </select>
                                <input type="hidden" name="client_id" id="client_id" readonly>

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
                                <label for="loanType" class="form-label">Loan Type <span
                                        class="text-danger">*</span></label>
                                <select id="loanType" name="loanType" class="select w-full">
                                    <option disabled selected>Choose Loan Type...</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger loanType_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="deposit" class="form-label">Fixed Deposit
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
                                <label for="loan_giving" class="form-label">Loan Given
                                    <span class="text-danger">*</span></label>
                                <input id="loan_giving" type="number" name="loan_giving" class="form-control"
                                    placeholder="xxxx" required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger loan_giving_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="installment" class="form-label">Installment
                                    <span class="text-danger">*</span></label>
                                <input id="installment" type="number" name="installment" class="form-control"
                                    placeholder="xxxx" required>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger installment_error"></span>
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
                                <label for="totalInterest" class="form-label">Total Interest
                                    <span class="text-danger">*</span></label>
                                <input id="totalInterest" type="number" name="totalInterest" class="form-control"
                                    placeholder="xxxx" required readonly>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger totalInterest_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="totalWithInterest" class="form-label">Total Loan include Interest
                                    <span class="text-danger">*</span></label>
                                <input id="totalWithInterest" type="number" name="totalWithInterest"
                                    class="form-control" placeholder="xxxx" required readonly>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger totalWithInterest_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="fixedLoanInstallment" class="form-label">Fixed Loan Installment
                                    <span class="text-danger">*</span></label>
                                <input id="fixedLoanInstallment" type="number" name="fixedLoanInstallment"
                                    class="form-control" placeholder="xxxx" required readonly>

                                <span class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger fixedLoanInstallment_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="fixedInterestInstallment" class="form-label">Fixed Interest Installment
                                    <span class="text-danger">*</span></label>
                                <input id="fixedInterestInstallment" type="number" name="fixedInterestInstallment"
                                    class="form-control" placeholder="xxxx" required readonly>

                                <span
                                    class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger fixedInterestInstallment_error"></span>
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div class="col-md-12 my-3 rounded-3 shadow-inner py-3 form-head">
                            <b class="text-uppercase">Personal Information</b>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input id="name" type="text" class="form-control" placeholder="Name" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="husbandName" class="form-label">Husband/father's Name <span
                                        class="text-danger">*</span></label>
                                <input id="husbandName" type="text" class="form-control"
                                    placeholder="Husband/father's Name" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="motherName" class="form-label">Mother's
                                    Name <span class="text-danger">*</span></label>
                                <input id="motherName" type="text" class="form-control" placeholder="Mother's Name"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="dob" class="form-label">Birth
                                    Reg.No/Voter ID No <span class="text-danger">*</span></label>
                                <input id="nid" type="number" class="form-control" placeholder="xxx-xxxx-xxx"
                                    maxlength="20" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="academyQualify" class="form-label">Academy
                                    Qualifications</label>
                                <input id="academyQualify" type="text" class="form-control"
                                    placeholder="Academy Qualifications" maxlength="20" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="dob" class="form-label">Date of
                                    Birth <span class="text-danger">*</span></label>
                                <input id="dob" class="form-control" data-single-mode="true" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="dob" class="form-label">Religion
                                    <span class="text-danger">*</span></label>
                                <div class="border p-3 rounded-3">
                                    <div class="form-check d-inline-block me-2">
                                        <input id="Islam" class="form-check-input" type="radio" value="Islam"
                                            onclick="javascript: return false;">
                                        <label class="form-check-label" for="Islam">Islam</label>
                                    </div>
                                    <div class="form-check d-inline-block me-2 mt-2 mt-sm-0">
                                        <input id="Hindu" class="form-check-input" type="radio" value="Hindu"
                                            onclick="javascript: return false;">
                                        <label class="form-check-label" for="Hindu">Hindu</label>
                                    </div>
                                    <div class="form-check d-inline-block me-2 mt-2 mt-sm-0">
                                        <input id="Buddha" class="form-check-input" type="radio" value="Buddha"
                                            onclick="javascript: return false;">
                                        <label class="form-check-label" for="Buddha">Buddha</label>
                                    </div>
                                    <div class="form-check d-inline-block me-2 mt-2 mt-sm-0">
                                        <input id="Christian" class="form-check-input" type="radio" value="Christian"
                                            onclick="javascript: return false;">
                                        <label class="form-check-label" for="Christian">Christian</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="dob" class="form-label">Occupation
                                    <span class="text-danger">*</span></label>
                                <div class="border p-3 rounded-3 @error('occupation') is-invalid @enderror">
                                    <div class="form-check me-2 d-inline-block">
                                        <input id="Business" class="form-check-input" type="radio" value="Business"
                                            onclick="javascript: return false;">
                                        <label class="form-check-label" for="Business">Business</label>
                                    </div>
                                    <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                        <input id="Jobs" class="form-check-input" type="radio" value="Jobs"
                                            onclick="javascript: return false;">
                                        <label class="form-check-label" for="Jobs">Jobs</label>
                                    </div>
                                    <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                        <input id="worker" class="form-check-input" type="radio" value="worker"
                                            onclick="javascript: return false;">
                                        <label class="form-check-label" for="worker">Worker</label>
                                    </div>
                                    <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                        <input id="Driver" class="form-check-input" type="radio" value="Driver"
                                            onclick="javascript: return false;">
                                        <label class="form-check-label" for="Driver">Driver</label>
                                    </div>
                                    <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                        <input id="Rickshaw-driver" class="form-check-input" type="radio"
                                            value="Rickshaw-driver" onclick="javascript: return false;">
                                        <label class="form-check-label" for="Rickshaw-driver">Rickshaw Driver</label>
                                    </div>
                                    <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                        <input id="housewife" class="form-check-input" type="radio" value="housewife"
                                            onclick="javascript: return false;">
                                        <label class="form-check-label" for="housewife">Housewife</label>
                                    </div>
                                    <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                        <input id="Others" class="form-check-input" type="radio" value="Others"
                                            onclick="javascript: return false;">
                                        <label class="form-check-label" for="Others">Others</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="dob" class="form-label">Gender
                                    <span class="text-danger">*</span></label>
                                <div class="border p-3 rounded-3 @error('gender') is-invalid @enderror">
                                    <div class="form-check me-2 d-inline-block">
                                        <input id="Male" class="form-check-input" type="radio" value="Male"
                                            onclick="javascript: return false;">
                                        <label class="form-check-label" for="Male">Male</label>
                                    </div>
                                    <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                        <input id="Female" class="form-check-input" type="radio" value="Female"
                                            onclick="javascript: return false;">
                                        <label class="form-check-label" for="Female">Female</label>
                                    </div>
                                    <div class="form-check me-2 d-inline-block mt-2 mt-sm-0">
                                        <input id="others" class="form-check-input" type="radio" value="others"
                                            onclick="javascript: return false;">
                                        <label class="form-check-label" for="others">others</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="mobile" class="form-label">Mobile
                                    <span class="text-danger">*</span></label>
                                <input id="mobile" type="number" class="form-control" placeholder="01xxx-xxxxxxx"
                                    maxlength="11" minlength="11" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-form">
                                <label for="client_image" class="form-label">Client Image <span
                                        class="text-danger">*</span></label>
                                <div class="w-52">
                                    <div
                                        class="border-2 border-dashed shadow-sm border-gray-200 dark-border-dark-5 rounded-2 p-5">
                                        <div class="h-40 position-relative image-fit cursor-pointer zoom-in mx-auto">
                                            <img class="rounded-2" id="preview_client_image" alt="client_image"
                                                src="{{ asset('storage/placeholder/profile.png') }}">
                                        </div>
                                    </div>
                                </div>
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
                                        {{-- <label for="Present_address" class="form-label">Present Address</label> --}}
                                        {{-- <textarea class="form-control" id="Present_address" cols="30" rows="3" readonly></textarea> --}}
                                        <p id="Present_address"></p>
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
                                <div class="col-md-12 mb-3">
                                    <div class="input-form">
                                        {{-- <label for="permanent_address" class="form-label">Permanent Address</label> --}}
                                        {{-- <textarea class="form-control" id="permanent_address" cols="30" rows="3" readonly></textarea> --}}
                                        <p id="permanent_address"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Guarantor Section -->
                        <div class="guarantor_sections">
                            <div class="row">
                                <div class="col-md-12 my-3 rounded-3 shadow-inner py-3 form-head">
                                    <b class="text-uppercase">Guarantor Informations - 1</b>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-form">
                                        <label for="guarantor_name_1" class="form-label">Name <span
                                                class="text-danger">*</span></label>
                                        <input id="guarantor_name_1" type="text" name="guarantor_name_1"
                                            class="form-control" placeholder="Name" required>

                                        <span
                                            class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger guarantor_name_1_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-form">
                                        <label for="guarantor_fatherName_1" class="form-label">Father's Name <span
                                                class="text-danger">*</span></label>
                                        <input id="guarantor_fatherName_1" type="text" name="guarantor_fatherName_1"
                                            class="form-control" placeholder="Father's Name" required>

                                        <span
                                            class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger guarantor_fatherName_1_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-form">
                                        <label for="guarantor_motherName_1" class="form-label">Mother's
                                            Name <span class="text-danger">*</span></label>
                                        <input id="guarantor_motherName_1" type="text" name="guarantor_motherName_1"
                                            class="form-control" placeholder="Mother's Name" required>

                                        <span
                                            class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger guarantor_motherName_1_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-form">
                                        <label for="guarantor_nid_1" class="form-label">Birth
                                            Reg.No/Voter ID No <span class="text-danger">*</span></label>
                                        <input id="guarantor_nid_1" type="number" name="guarantor_nid_1"
                                            class="form-control" placeholder="xxx-xxxx-xxx" maxlength="20" required>

                                        <span
                                            class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger guarantor_nid_1_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-form">
                                        <label for="guarantor_image_1" class="form-label">Guarantor Image</label>
                                        <div class="w-52">
                                            <div
                                                class="border-2 border-dashed shadow-sm border-gray-200 dark-border-dark-5 rounded-2 p-5">
                                                <div
                                                    class="h-40 position-relative image-fit cursor-pointer zoom-in mx-auto">
                                                    <img class="rounded-2" id="preview_guarantor_1_image"
                                                        alt="guarantor_image_1"
                                                        src="{{ asset('storage/placeholder/profile.png') }}">
                                                </div>
                                                <div class="mx-auto position-relative mt-5">
                                                    {{-- <button type="button" class="btn btn-primary w-full">Change Logo</button> --}}
                                                    <label for="guarantor_image_1" class="btn btn-primary form-control"
                                                        style="font-size: 24px"><i class='bx bx-camera'></i></label>
                                                    <input type="file" id="guarantor_image_1" name="guarantor_image_1"
                                                        class="w-full h-full top-0 start-0 position-absolute opacity-0 cursor-pointer"
                                                        onchange="getImagePreview(event, 'preview_guarantor_1_image')"
                                                        accept="image/*">
                                                </div>
                                            </div>
                                        </div>

                                        <span
                                            class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger guarantor_image_1_error"></span>
                                    </div>
                                </div>
                                <!-- Guarantor Address -->
                                <div class="permanent_address">
                                    <div class="row">
                                        <div class="col-md-12 my-3 rounded-3 shadow-inner py-3 form-head">
                                            <b class="text-uppercase">Guarantor Address - 1</b>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="input-form">
                                                <label for="g_house_1" class="form-label">House/Appertment/Road <span
                                                        class="text-danger">*</span></label>
                                                <input id="g_house_1" type="text" name="g_house_1"
                                                    class="form-control" placeholder="House/Appertment/Road"
                                                    maxlength="100" required>

                                                <span
                                                    class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger g_house_1_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="input-form">
                                                <label for="g_village_1" class="form-label">Village
                                                    <span class="text-danger">*</span></label>
                                                <input id="g_village_1" type="text" name="g_village_1"
                                                    class="form-control" placeholder="Village" maxlength="100" required>

                                                <span
                                                    class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger g_village_1_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="input-form">
                                                <label for="g_postOffice_1" class="form-label">Post Office </label>
                                                <input id="g_postOffice_1" type="text" name="g_postOffice_1"
                                                    class="form-control" placeholder="Post Office" maxlength="100">
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="input-form">
                                                <label for="g_postcodes_1" class="form-label">Post Code <span
                                                        class="text-danger">*</span></label>
                                                <select id="g_postcodes_1" name="g_postcodes_1"
                                                    class="form-control select">
                                                    <option disabled selected>First Choose a District</option>
                                                </select>

                                                <span
                                                    class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger g_postcodes_1_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="input-form">
                                                <label for="g_upazilas_1" class="form-label">Police Station <span
                                                        class="text-danger">*</span></label>
                                                <input id="g_upazilas_1" type="text" name="g_upazilas_1"
                                                    class="form-control" placeholder="Police Station" maxlength="100"
                                                    required>

                                                <span
                                                    class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger g_upazilas_1_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="input-form">
                                                <label for="g_districts_1" class="form-label">Districts <span
                                                        class="text-danger">*</span></label>
                                                <select id="g_districts_1" name="g_districts_1"
                                                    class="form-control select">
                                                    <option disabled selected>First Choose a Division</option>
                                                </select>

                                                <span
                                                    class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger g_districts_1_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="input-form">
                                                <label for="g_divisions_1" class="form-label">Divisions <span
                                                        class="text-danger">*</span></label>
                                                <select id="g_divisions_1" name="g_divisions_1"
                                                    class="form-control select">
                                                </select>

                                                <span
                                                    class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger g_divisions_1_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="guarantor_sections">
                            <div class="row">
                                <div class="col-md-12 my-3 rounded-3 shadow-inner py-3 form-head">
                                    <b class="text-uppercase">Guarantor Informations - 2</b>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-form">
                                        <label for="guarantor_name_2" class="form-label">Name <span
                                                class="text-danger">*</span></label>
                                        <input id="guarantor_name_2" type="text" name="guarantor_name_2"
                                            class="form-control" placeholder="Name">

                                        <span
                                            class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger guarantor_name_2_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-form">
                                        <label for="guarantor_fatherName_2" class="form-label">Father's Name <span
                                                class="text-danger">*</span></label>
                                        <input id="guarantor_fatherName_2" type="text" name="guarantor_fatherName_2"
                                            class="form-control" placeholder="Father's Name">

                                        <span
                                            class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger guarantor_fatherName_2_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-form">
                                        <label for="guarantor_motherName_2" class="form-label">Mother's
                                            Name <span class="text-danger">*</span></label>
                                        <input id="guarantor_motherName_2" type="text" name="guarantor_motherName_2"
                                            class="form-control" placeholder="Mother's Name">

                                        <span
                                            class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger guarantor_motherName_2_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-form">
                                        <label for="guarantor_nid_2" class="form-label">Birth
                                            Reg.No/Voter ID No <span class="text-danger">*</span></label>
                                        <input id="guarantor_nid_2" type="number" name="guarantor_nid_2"
                                            class="form-control" placeholder="xxx-xxxx-xxx" maxlength="20">

                                        <span
                                            class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger guarantor_nid_2_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input-form">
                                        <label for="guarantor_image_2" class="form-label">Guarantor Image</label>
                                        <div class="w-52">
                                            <div
                                                class="border-2 border-dashed shadow-sm border-gray-200 dark-border-dark-5 rounded-2 p-5">
                                                <div
                                                    class="h-40 position-relative image-fit cursor-pointer zoom-in mx-auto">
                                                    <img class="rounded-2" id="preview_guarantor_2_image"
                                                        alt="guarantor_image_2"
                                                        src="{{ asset('storage/placeholder/profile.png') }}">
                                                </div>
                                                <div class="mx-auto position-relative mt-5">
                                                    {{-- <button type="button" class="btn btn-primary w-full">Change Logo</button> --}}
                                                    <label for="guarantor_image_2" class="btn btn-primary form-control"
                                                        style="font-size: 24px"><i class='bx bx-camera'></i></label>
                                                    <input type="file" id="guarantor_image_2" name="guarantor_image_2"
                                                        class="w-full h-full top-0 start-0 position-absolute opacity-0 cursor-pointer"
                                                        onchange="getImagePreview(event, 'preview_guarantor_2_image')"
                                                        accept="image/*">
                                                </div>
                                            </div>
                                        </div>

                                        <span
                                            class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger guarantor_image_2_error"></span>
                                    </div>
                                </div>
                                <!-- Guarantor Address -->
                                <div class="permanent_address">
                                    <div class="row">
                                        <div class="col-md-12 my-3 rounded-3 shadow-inner py-3 form-head">
                                            <b class="text-uppercase">Guarantor Address - 2</b>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="input-form">
                                                <label for="g_house_2" class="form-label">House/Appertment/Road <span
                                                        class="text-danger">*</span></label>
                                                <input id="g_house_2" type="text" name="g_house_2"
                                                    class="form-control" placeholder="House/Appertment/Road"
                                                    maxlength="100">

                                                <span
                                                    class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger g_house_2_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="input-form">
                                                <label for="g_village_2" class="form-label">Village
                                                    <span class="text-danger">*</span></label>
                                                <input id="g_village_2" type="text" name="g_village_2"
                                                    class="form-control" placeholder="Village" maxlength="100">

                                                <span
                                                    class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger g_village_2_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="input-form">
                                                <label for="g_postOffice_2" class="form-label">Post Office </label>
                                                <input id="g_postOffice_2" type="text" name="g_postOffice_2"
                                                    class="form-control" placeholder="Post Office" maxlength="100">

                                                <span
                                                    class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger g_postOffice_2_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="input-form">
                                                <label for="g_postcodes_2" class="form-label">Post Code <span
                                                        class="text-danger">*</span></label>
                                                <select id="g_postcodes_2" name="g_postcodes_2"
                                                    class="form-control select">
                                                    <option disabled selected>First Choose a District</option>
                                                </select>

                                                <span
                                                    class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger g_postcodes_2_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="input-form">
                                                <label for="g_upazilas_2" class="form-label">Police Station <span
                                                        class="text-danger">*</span></label>
                                                <input id="g_upazilas_2" type="text" name="g_upazilas_2"
                                                    class="form-control" placeholder="Police Station" maxlength="100">

                                                <span
                                                    class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger g_upazilas_2_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="input-form">
                                                <label for="g_districts_2" class="form-label">Districts <span
                                                        class="text-danger">*</span></label>
                                                <select id="g_districts_2" name="g_districts_2"
                                                    class="form-control select">
                                                    <option disabled selected>First Choose a Division</option>
                                                </select>

                                                <span
                                                    class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger g_districts_2_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="input-form">
                                                <label for="g_divisions_2" class="form-label">Divisions <span
                                                        class="text-danger">*</span></label>
                                                <select id="g_divisions_2" name="g_divisions_2"
                                                    class="form-control select">
                                                </select>

                                                <span
                                                    class="ms-sm-auto mt-1 mt-sm-0 fs-xs text-danger g_divisions_2_error"></span>
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
            <button type="submit" id="form_submit" class="btn btn-primary mt-5 w-full">Save</button>
        </div>
        </form>
    </div>
    </div>
@endsection

@section('customFunctions')
    /**
    * Choose Divisions
    */
    divisions("g_divisions_1")
    divisions("g_divisions_2")

    /**
    * Choose Districts
    */
    $('#g_divisions_1').on('change', function() {
    var division_id = $(this).find(':selected').data('id')
    districts('g_districts_1', division_id)
    })

    $('#g_divisions_2').on('change', function() {
    var division_id = $(this).find(':selected').data('id')
    districts('g_districts_2', division_id)
    })

    /**
    * Choose Upazila
    * Choose Post Codes
    */
    $('#g_districts_1').on('change', function() {
    var district_id = $(this).find(':selected').data('id')
    policePost('g_postcodes_1', district_id)
    })

    $('#g_districts_2').on('change', function() {
    var district_id = $(this).find(':selected').data('id')
    policePost('g_postcodes_2', district_id)
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

            $("#loan_giving").on("keyup", function() {
                totalValue();
            })

            $("#interest").on("keyup", function() {
                totalValue();
            })
            // Total Calculation
            function totalValue(total_loan, loan_ints) {
                var expiry_date = $("#installment").val();
                var interest = $("#interest").val();
                var total = $("#loan_giving").val();
                var total_int = ((total / 100) * interest);
                var total_interest = Math.round(total_int);
                var ceil = Math.ceil(parseInt(total) / parseInt(expiry_date));
                console.log(ceil)
                if (ceil % 1 == 0) {
                    var ceil_i = ceil;
                } else {
                    var ceil_i = Math.round(parseFloat(ceil) + parseFloat(1));
                };
                var total_with_int = Math.round(parseFloat(total) + parseFloat(total_int));
                var interest_ints = total_int / expiry_date;
                if (interest_ints % 1 == 0) {
                    var interest_i = interest_ints;
                } else {
                    var interest_i = Math.round(parseFloat(interest_ints) + parseFloat(1));
                };
                $("#fixedLoanInstallment").val(ceil_i);
                $("#totalInterest").val(total_interest);

                $("#totalWithInterest").val(total_with_int);
                $("#fixedInterestInstallment").val(interest_i);
            }

            $("#volume").on('change', function() {
                getAccount()
            })
            $("#center").on('change', function() {
                getAccount()
            })

            // Get Savings Account
            function getAccount() {
                var volume = $("#volume").val();
                var center = $("#center").val();
                var account = $("#accNo");
                var url =
                    "{{ Route('registration.newSavings.get.account', ['volID' => ':volume', 'centerID' => ':center']) }}";
                url = url.replace(':volume', volume);
                url = url.replace(':center', center);

                if (center != null) {
                    $.ajax({
                        url: url,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data) {
                            var options = []
                            options[0] = '<option disabled selected>Choose Account...</option>'
                            if (data) {
                                $.each(data, function(key, acc) {
                                    options[++key] = '<option value="' + acc.acc_no + '">' + acc
                                        .acc_no + '</option>'
                                })
                            } else {
                                options[1] = '<option disabled selected>No Records Found!</option>'
                            }

                            account.html('')
                            account.html(options)
                        }
                    })
                }
            }

            // Get Account Informations
            $("#accNo").on('change', function() {
                let account = $(this).val()
                let url = "{{ Route('registration.newSavings.get.account.info', ':acc') }}"
                url = url.replace(':acc', account)

                $.ajax({
                    url: url,
                    type: "GET",
                    dataType: 'JSON',
                    success: function(data) {
                        $("#client_id").val(data.id)
                        $("#name").val(data.name)
                        $("#husbandName").val(data.husband_or_father_name)
                        $("#motherName").val(data.mother_name)
                        $("#nid").val(data.nid)
                        $("#academyQualify").val(data.academic_qualification)
                        $("#dob").val(data.dob)
                        $('input:radio').filter('[value="' + data.religion + '"]').attr(
                            'checked', true)
                        $('input:radio').filter('[value="' + data.occupation + '"]').attr(
                            'checked', true)
                        $('input:radio').filter('[value="' + data.gender + '"]').attr('checked',
                            true)
                        $("#mobile").val(data.mobile)
                        var img = "{{ asset('storage/register/:image') }}"
                        img = img.replace(':image', data.client_image)
                        $("#preview_client_image").attr('src', img)
                        $("#Present_address").html(data.Present_address)
                        $("#permanent_address").html(data.permanent_address)
                    }
                })
            })

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
            $('#loan_registration').on('submit', function(e) {
                e.preventDefault()
                var formData = new FormData(this)
                var url = "{{ Route('registration.newLoans.store') }}"
                var btn = $("#form_submit")

                $.ajax({
                    url: url,
                    type: 'POST',
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
