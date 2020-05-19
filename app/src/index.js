import React from 'react';
import ReactDOM from 'react-dom';
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {Home} from "./pages/Home";
import {FourOhFour} from "./pages/FourOhFour";
import {Navigation} from "./components/Navigation";
import {SoldierOpen} from "./pages/SoldierOpen";

const Routing = () => (
	<>
		<Navigation/>
	<BrowserRouter>
	<Switch>
	<Route exact path="/" component={Home}/>
	<Route exact path="/SoldierOpen" component={SoldierOpen}/>
	<Route component={FourOhFour}/>
	</Switch>
	</BrowserRouter>
	</>
);
ReactDOM.render(<Routing/>, document.querySelector('#root'));