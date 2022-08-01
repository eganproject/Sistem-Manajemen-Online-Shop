import React, { Component } from 'react';
import axios from 'axios';
import { toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

class CreateModal extends Component {

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

// update employe data
    storeEmployeData = () =>{
axios.post('/dashboard/employe/store', {
    employeName: this.state.employeName,
    employeSalary: this.state.employeSalary
}).then((response)=> {
toast.success("Employe Created Successfully");
setTimeout(() =>{

    location.reload();
},2500)
})
    }

 render(){
    return (
        <div className="modal fade" id="modalCreate" tabIndex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                className='form-control'
                id="employeName" 
                onChange={this.inputEmployeName} />
            </div>
            <div className="form-group">
                <input type="text" 
                                className='form-control'
                id="employeSalary" 
                onChange={this.inputEmployeSalary} />
            </div>
           

         </form>
            </div>
            <div className="modal-footer">
                <input type="button" 
                className="btn btn-info"
                value="save"
                onClick={this.storeEmployeData}/>
              <button type="button" className="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    )
 }

}

export default CreateModal;