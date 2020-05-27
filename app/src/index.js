import React from 'react';
import ReactDOM from 'react-dom';
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {Home} from "./pages/Home/Home";
import {FourOhFour} from "./pages/FourOhFour/FourOhFour";
import {SoldierOpen} from "./pages/SoldierOpenRequest/SoldierOpen";
import {SoldierHistory} from "./pages/SoldierHistory/SoldierHistory";
import {Request} from "./pages/request/Request"
import {Navigation} from "./shared/components/main-nav/Navigation";
import {applyMiddleware, createStore} from "redux";
import {Provider} from "react-redux";
import thunk from "redux-thunk";
import reducers from "./shared/reducers/reducer";
import {CreateAccount} from "./pages/CreateAccount/CreateAccount";
import {ProfilePage} from "./pages/ProfilePage/profile-page";
import {RequestContent} from "./pages/AddRequest/RequestContent";
import {RequestDetail} from "./pages/RequestDetail/request-detail";
import {Create} from "./pages/AddRequest/Create";

const store = createStore(reducers, applyMiddleware(thunk));
const Routing = (store) => (
	<>
		<Provider store={store}>
			<Navigation/>
				<BrowserRouter>
					<Switch>
						<Route exact path="/" component={Home}/>
						<Route exact path="/SoldierOpen" component={SoldierOpen}/>
						<Route exact path="/SoldierHistory" component={SoldierHistory}/>
						<Route exact path="/RequestContent/:requestId" component={RequestContent} requestId=":requestId"/>
						<Route exact path="/CreateAccount" component={CreateAccount}/>
						<Route exact path="/ProfilePage" component={ProfilePage}/>
						<Route exact path="/Create" component={Create}/>
						<Route exact path="/RequestDetail" component={RequestDetail}/>
						<Route exact path="/RequestDetail/:requestId" component={RequestDetail} requestId=":requestId"/>
						<Route component={FourOhFour}/>
					</Switch>
				</BrowserRouter>
		</Provider>
	</>
);
ReactDOM.render(Routing(store), document.querySelector('#root'));


