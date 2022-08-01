import React from 'react';
import ReactDOM from 'react-dom';
import Table from './employeList/Table';


function App() {
    return (
        <div className="container">
    <div className="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 className="h2">COBA AJA</h1>
    </div>
    <div className="row justify-content-center">
        {/*Component Here*/}
        <Table/>
    </div>
</div>
);

}

export default App;