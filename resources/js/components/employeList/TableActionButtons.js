import axios from 'axios';
import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import ViewModal from './Modals/ViewModal';
import UpdateModal from './Modals/UpdateModal'
import DeleteModal from './modals/DeleteModal';


class TableActionButtons extends Component {

    constructor(props){
        super(props);
this.state = {
    currentEmployeName : null,
    currentEmployeSalary : null
}

    }

    // Getting  individual employe data
    getEmployeDetail = (id) =>{
axios.post('/dashboard/individual/employe/detail', {
    employeId : id
}).then((response) => {
    this.setState({
        currentEmployeName: response.data.employe_name,
        currentEmployeSalary:response.data.salary 
    })
    console.log(response.data);
})

    }

 render(){
    return (
        <div className="btn-group" role="group">
            <button 
            type="button" 
            className="btn btn-primary" 
            data-bs-toggle="modal" 
            data-bs-target={'#viewModal'+this.props.eachRowId}
            onClick={ () => { this.getEmployeDetail(this.props.eachRowId)}}
            >View</button>
            <ViewModal modalId={this.props.eachRowId} employeData={this.state} />

            <button type="button" 
            className="btn btn-info"
            data-bs-toggle="modal" 
            data-bs-target={'#updateModal'+this.props.eachRowId}
            onClick={ () => { this.getEmployeDetail(this.props.eachRowId)}}
            >Edit</button>
<UpdateModal modalId={this.props.eachRowId} employeData={this.state} />

            <button type="button" 
            className="btn btn-danger"
            data-bs-toggle="modal" 
            data-bs-target={'#deleteModal'+this.props.eachRowId}
            onClick={ () => { this.getEmployeDetail(this.props.eachRowId)}}
            >Delete</button>
            <DeleteModal modalId={this.props.eachRowId} employeData={this.state} />
        </div>
    )
 }

}

export default TableActionButtons;