import React, { Component } from 'react';
import { toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

class DeleteModal extends Component {

    constructor(props){
        super(props);

    }
deleteEmployeData = (employe) => {
    axios.delete('/dashboard/employe/delete/'+employe).then(() => {
        toast.error('Employe Deleted success')

        setTimeout(() => {
            location.reload();
        }, 2500);
    })
}

 render(){
    return (
        <div className="modal fade" id={"deleteModal"+this.props.modalId} tabIndex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div className="modal-dialog">
          <div className="modal-content">
            <div className="modal-header">
              <h5 className="modal-title" id="exampleModalLabel">Details</h5>
              <button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div className="modal-body">
         Are you sure want to delete it ?
            </div>
            <div className="modal-footer">
           
              <button type="button" className="btn btn-danger" data-bs-dismiss="modal" onClick={ ()=>{this.deleteEmployeData(this.props.modalId)}}>Yes</button>
              <button type="button" className="btn btn-secondary" data-bs-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>
    )
 }

}

export default DeleteModal;