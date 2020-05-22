import React from 'react';
import ReactDOM from 'react-dom';
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {Home} from "./pages/Home/Home";
import {FourOhFour} from "./pages/FourOhFour/FourOhFour";
import {SoldierOpen} from "./pages/SoldierOpenRequest/SoldierOpen";
import {SoldierHistory} from "./pages/SoldierHistory/SoldierHistory";
import {Navigation} from "./shared/components/main-nav/Navigation";
import {applyMiddleware, createStore} from "redux";
import Provider from "react-redux/lib/components/Provider";
import thunk from "redux-thunk";

const store = createStore( applyMiddleware(thunk));

const Routing = (store) => (
	<>
		<Provider store={store}>
			<Navigation/>
				<BrowserRouter>
					<Switch>
						<Route exact path="/Home" component={Home}/>
						<Route exact path="/SoldierOpen" component={SoldierOpen}/>
						<Route exact path="/SoldierHistory" component={SoldierHistory}/>
						<Route component={FourOhFour}/>
					</Switch>
				</BrowserRouter>
		</Provider>
	</>
);
ReactDOM.render(<Routing/>, document.querySelector('#root'));