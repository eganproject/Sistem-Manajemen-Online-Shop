import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class Timer extends Component {
    constructor(props){
        super(props)
        this.state = {
            time : props.start
        }
    }

    componentDidMount(){
        this.addInterval = setInterval(() => this.increase(), 1000);
    }

    componentWillUnMount(){
        clearInterval(this.addInterval)
    }

    increase(){
        this.setState((state, props) => ({
            time : parseInt(state.time) + 1
        }))
    }

    render(){
        return (
            <div>{this.state.time} Detik</div>
        )
    }

}

function Biodata(props){
    return <span>dengan umur {props.umur}</span>;
}

function Sapa(props){
    return <h1>Hello {props.name} <Biodata umur={props.umur} /> </h1>;
}


