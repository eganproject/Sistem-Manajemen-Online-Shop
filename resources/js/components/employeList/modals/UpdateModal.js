import React, { Component } from 'react';
import { toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

class UpdateModal extends Component {

    constructor(props){
        super(props);

        this.state ={
            employeName : null,
            employeSalary : null
        }
    }
// Updating empployeName State
inputEmployeName =(event) =>{
this.setState({
    employeName : event.target.value
})
}

// Updating Employe Salary State
inputEmployeSalary =(event) =>{
this.setState({
    employeSalary : event.target.value
})
}

static getDerivedStateFromProps(props, current_state){
    let employeUpdate ={
        employeName: null,
        employeSalary : null
    }

    // UPDATING DATA FROM INPUT    
if(current_state.employeName && (current_state.employeName !== props.employeData.currentEmployeName)){
    return null;
}
if(current_state.employeSalary && (current_state.employeSalary !== props.employeData.currentEmployeSalary)){
    return null;
}

    // uPDATING DATA FROM PROPS BELOW
    if(current_state.employeName !== props.employeData.currentEmployeName || current_state.employeName === props.employeData.currentEmployeName){
        employeUpdate.employeName = props.employeData.currentEmployeName;
    }
    if(current_state.employeSalary !== props.employeData.currentEmployeSalary|| current_state.employeSalary === props.employeData.currentEmployeSalary){
        employeUpdate.employeSalary = props.employeData.currentEmployeSalary;
    }
    return employeUpdate;
}

// update employe data
    updateEmployeData = () =>{
axios.post('/dashboard/employe/update', {
    employeId: this.props.modalId,
    employeName: this.state.employeName,
    employeSalary: this.state.employeSalary
}).then((response)=> {
toast.success("Employe Updated Successfully");
setTimeout(() =>{

    location.reload();
},2500)
})
    }

 render(){
    return (
        <div className="modal fade" id={"updateModal"+this.props.modalId} tabIndex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div className="modal-dialog">
          <div className="modal-content">
            <div className="modal-header">
              <h5 className="modal-title" id="exampleModalLabel">Details</h5>
              <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div className="modal-body">
         <form className="form">
            <div className="form-group">
                <input type="text" 
                id="employeName" 
                value={this.state.employeName ?? ""}
                onChange={this.inputEmployeName} />
            </div>
            <div className="form-group">
                <input type="text" 
                id="employeSalary" 
                value={this.state.employeSalary ?? ""}
                onChange={this.inputEmployeSalary} />
            </div>
           

         </form>
            </div>
            <div className="modal-footer">
            <div className="form-group">
                <input type="submit" 
                className="btn btn-info"
                value="update"
                onClick={this.updateEmployeData} />
            </div>
              <button type="button" className="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    )
 }

}

export default UpdateModal;