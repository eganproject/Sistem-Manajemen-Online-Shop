import React, { Component } from 'react';
import TableRow from './TableRow';
import { ToastContainer, toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';
import CreateModal from './modals/CreateModal';

class Table extends Component {

constructor(props){
    super(props);

    this.state ={
        employes : [], 
    }
}

// lifecycle method
componentDidMount(){
    this.getEmployeList();
}

//Get employe list
getEmployeList = () => {
    let self = this;
axios.get('/dashboard/employe/list').then(function(response){
    self.setState({
        employes : response.data
    })
})
}
    render(){
        return (
            <div>
            <div className="row text-right mb-3 pb-3">
            <button type="button" className="btn btn-info text-right col-3 offset-md-9" data-toggle="modal" data-target={'#modalCreate'}>
            Add New Employee
            </button>
                <CreateModal/>
            </div>
            <table className="table">
                <ToastContainer/>
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Salary</th>
                    <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {this.state.employes.map(function(x, i){
                        return <TableRow key={i} data={x}/>
                    })}
                    
                </tbody>
            </table>
                    </div>
        );
    }


}



export default Table;