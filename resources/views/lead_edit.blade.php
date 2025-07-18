@extends('layouts.dashboard')

@section('title', 'Leads | LYNQ')

@section('js')
    <script src="{{ asset('js/leads_script.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelector('.edit-btn').click();
        })

    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/leads-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/linq_portal_styles.css') }}">
@endsection

@section('main_section')
    @section('lead_active')
        active
    @endsection
    <section class="main-content">
        <div class="headline">
            <h1>Leads</h1>
            <button type="submit" class="add-btn" id="addLeadBtn"><i class="fa-solid fa-plus"></i><i
                    class="fa-thin fa-pipe"></i>Add Lead</button>
            <div class="filter-items-container">
                <i class="fa-regular fa-sliders" onclick="openDropDown(); event.stopPropagation();"></i>
                <div class="filter-dropdown-menu">
                    <table class="filter-dropdown-menu-item">
                        <tr>
                            <th>Sort By:</th>
                        </tr>
                        <tr>
                            <td>Company Name</td>
                            <td>Ascending</td>
                        </tr>
                        <tr>
                            <td>Assigned To</td>
                            <td>Descending</td>
                        </tr>
                        <tr>
                            <td>Stage</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                        </tr>
                        <tr>
                            <td>Closing Date</td>
                        </tr>
                        <tr>
                            <td>Amount</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Assigned To</th>
                        <th>Created By</th>
                        <th>Stage</th>
                        <th>Status</th>
                        <th>Closing Date</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>

                @isset ($lead)
                    <tr>
                        <td>{{ $lead->name }}</td>
                        <td>{{ $lead->company }}</td>
                        <td>{{ $lead->assigned_to_first_name . " " . $lead->assigned_to_last_name }}</td>
                        <td>{{ $lead->created_by_first_name . " " . $lead->created_by_last_name }}</td>
                        <td>{{ $lead->stage }}</td>
                        <td>{{ $lead->status }}</td>
                        <td>{{ $lead->closing_date }}</td>
                        <td>{{ $lead->amount }}</td>
                        <td>
                            <div class="action-btn-container">
                                <button type="submit" class="edit-btn action-btn edit-lead-btn">Edit</button>
                                <button type="submit" class="delete-btn action-btn">Delete</button>
                            </div>
                        </td>
                    </tr>

                @endisset


                <!-- <tbody>
                                                                    <tr>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td>
                                                                                <a
                                                                                    href="#"
                                                                                    class="btn-edit edit-lead-btn"
                                                                                    data-id="{{-- $post->id --}}"
                                                                                    data-name="{{-- $post->name --}}"
                                                                                    data-company="{{-- $post->company --}}"
                                                                                    data-assigned-to="{{-- $post->assigneTo --}}"
                                                                                    data-stage="{{-- $post->stage --}}"
                                                                                    data-status="{{-- $post->status --}}"
                                                                                    data-closing-date="{{-- $post->closingaDate --}}"
                                                                                    data-amount="{{-- $post->amount --}}"
                                                                                    data-created-by="{{-- $post->createdBy ?? 'Unknown' --}}"
                                                                                >
                                                                                    Edit
                                                                                </a>

                                                                                {{-- <form action="{{ route('leads.destroy', $post->id) }}" method="POST" class="d-inline">
                                                                                    <button type="submit" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</button>
                                                                                </form> --}}
                                                                            </td>
                                                                        </tr>
                                                                    </tbody> -->
            </table>
        </div>
    </section>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- Form for add --}}
    <form method="POST" action="{{ route('lead.store') }}" class="sidebar-form" id="sidebarAddForm">
        @csrf
        @method('post')
        <div class="sidebar-header">
            <div class="upper-part">
                <div class="title-container">
                    <h2>Add Lead</h2>
                    <button class="close-sidebar-btn" type="button" id="closeSidebarBtn">&times;</button>
                </div>

                <div class="hr-top">
                    <hr style="border: 1px solid #0c0c0c; width: 90%; margin: 20px;">
                </div>
            </div>
            <div class="lower-part">
                <p>Created By</p>
                <p id="current-user" class="current-user">{{ auth()->user()->first_name . " " . auth()->user()->last_name }}
                </p>
                <input type="hidden" name="created_by" value="{{ auth()->id() }}">
            </div>
        </div>
        <div class="sidebar-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter Name" required>
            </div>
            <div class="form-group">
                <label for="companyName">Company Name</label>
                <input type="text" name="company" id="companyName" placeholder="Enter Company Name" required>
            </div>
            <div class="form-group">
                <label for="assignedTo">Assigned To</label>
                <select id="assignedTo">
                    <option value="">Select Sales Rep</option>
                </select>
            </div>
            <div class="form-group">
                <label for="stage">Stage</label>
                <select id="stage" name="stage" required>
                    <option value="">Select Stage</option>
                    <option value="new">New</option>
                    <option value="contacted">Contacted</option>
                    <option value="proposal sent">Proposal Sent</option>
                    <option value="won">Won</option>
                    <option value="lost">Lost</option>
                </select>
            </div>
            <div class="form-group">
                <label for="closingDate">Closing Date</label>
                <input type="date" id="closingDate" name="closing_date" required> <span class="calendar-icon"></span>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" step="0.01" pattern="^\d*(\.\d{0,2})?$" max="9999999999999999.99"
                    id="amount" placeholder="0.00" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="">Select Status</option>
                    <option value="active">Active</option>
                    <option value="follow-up">Follow-up</option>
                    <option value="cold">Cold</option>
                </select>
            </div>
        </div>
        <div class="sidebar-footer">
            <button type="button" class="cancel-btn" id="cancel-sidebar-btn">Cancel</button>
            <button type="submit" class="save-btn">Save</button>
        </div>
    </form>

    {{-- Form for update --}}
    <form method="POST" action="{{ route('lead.update', ['lead' => $lead]) }}" class="sidebar-form" id="sidebarUpdateForm">
        @csrf
        @method('put')
        <div class="sidebar-header">
            <div class="upper-part">
                <div class="title-container">
                    <h2>Edit Lead</h2>
                    <button class="close-sidebar-btn" type="button" id="closeSidebarBtn"
                        onclick="location.href = '{{ route('leads') }}'">&times;</button>
                </div>

                <div class="hr-top">
                    <hr style="border: 1px solid #0c0c0c; width: 90%; margin: 20px;">
                </div>
            </div>
            <div class="lower-part">
                <p>Created By</p>
                <p id="current-user" class="current-user">

                    {{ $data->created_by_first_name . " " . $data->created_by_last_name }}
                </p>
                <input type="hidden" name="created_by" value="{{ auth()->id() }}">
            </div>
        </div>
        <div class="sidebar-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter Name" value="{{ $data->name }}" required>
            </div>
            <div class="form-group">
                <label for="companyName">Company Name</label>
                <input type="text" name="company" id="companyName" placeholder="Enter Company Name"
                    value="{{ $data->company }}" required>
            </div>
            <div class="form-group">
                <label for="assignedTo">Assigned To</label>
                <select id="assignedTo" name="assigned_to">
                    <option value="">Select Sales Rep</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $lead->assigned_to == $user->id ? 'selected' : '' }}>
                            {{ $user->first_name }} {{ $user->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="stage">Stage</label>
                <select id="stage" name="stage" required>
                    <option value="">Select Stage</option>
                    <option value="new" {{ old('stage', $lead->stage) === 'new' ? 'selected' : '' }}>New</option>
                    <option value="contacted" {{ old('stage', $lead->stage) === 'contacted' ? 'selected' : '' }}>Contacted
                    </option>
                    <option value="proposal sent" {{ old('stage', $lead->stage) === 'proposal sent' ? 'selected' : '' }}>
                        Proposal Sent</option>
                    <option value="won" {{ old('stage', $lead->stage) === 'won' ? 'selected' : '' }}>Won</option>
                    <option value="lost" {{ old('stage', $lead->stage) === 'lost' ? 'selected' : '' }}>Lost</option>
                </select>
            </div>
            <div class="form-group">
                <label for="closingDate">Closing Date</label>
                <input type="date" id="closingDate" name="closing_date" required value="{{ $data->closing_date }}"> <span
                    class="calendar-icon"></span>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" name="amount" step="0.01" pattern="^\d*(\.\d{0,2})?$" max="9999999999999999.99"
                    id="amount" placeholder="0.00" required value="{{ $data->amount }}">
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="">Select Status</option>
                    <option value="active" {{ old('status', $lead->status ?? '') === 'active' ? 'selected' : '' }}>Active
                    </option>
                    <option value="follow-up" {{ old('status', $lead->status ?? '') === 'follow-up' ? 'selected' : '' }}>
                        Follow-up</option>
                    <option value="cold" {{ old('status', $lead->status ?? '') === 'cold' ? 'selected' : '' }}>Cold</option>
                </select>
            </div>
        </div>
        <div class="sidebar-footer">
            <button type="button" class="cancel-btn" id="cancel-sidebar-btn"
                onclick="location.href = '{{ route('leads') }}'">Cancel</button>
            <button type="submit" class="save-btn update-btn">Update</button>
        </div>
    </form>


@endsection