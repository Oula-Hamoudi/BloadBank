<x-backend.layouts.master>
    
    <div class="container-fluid px-4">
        <h1 class="mt-4">Active Donors List</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">
                Dashboard
            </li>
            <li class="breadcrumb-item active">
                Donors
            </li>
            <li class="breadcrumb-item active">    
                Active Donors
            </li>
        </ol>
      
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Active donors list
            </div>
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>DOB</th>
                            <th>BL Group</th>
                            <th>Area</th>
                            <th>Post Code</th>
                            <th>Joined at</th>
                            <th>Last donated</th>
                            <th>Action</th>
                        </tr> 
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>12-12-12</td>
                            <td>O+</td>
                            <td>Dhaka</td>
                            <td>1430</td>
                            <td>2011/04/25</td>
                            <td>4months ago</td>
                            <td class="d-flex"> 
                                
                                <a href="" title="view" class="btn btn-info btn-sm" style="color: white" ><i class="fa-solid fa-eye"></i></a> 
                                
                                
                                
                                <a href="" title="make not ready" class="btn btn-danger btn-sm" style="margin-left: 3px" ><i class="fas fa-toggle-off"></i></a> 
                             
                        </tr>
                     
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-backend.layouts.master>