import { Component } from "react";


class Spinner extends Component {

    render(){
        return (
          <div class="spinner-grow" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        );
    }


}


export default Spinner;