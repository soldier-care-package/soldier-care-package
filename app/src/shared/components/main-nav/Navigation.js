import React from "react"
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {SignUpModal} from "./sign-up/SignUpModal";
import {SignInModal} from "./sign-in/SignInModel";

export const Navigation = () => {
	return (
		<>
			<Navbar bg="primary" variant="dark">
				<Navbar.Brand href="/" >Home</Navbar.Brand>
				<Nav className="mr-auto">
					<Nav.Link href="/Create"> + New Request</Nav.Link>
					<Nav.Link href="/SoldierOpen">My Lists</Nav.Link>
					<Nav.Link href="/ProfilePage">Profile</Nav.Link>
					<SignUpModal/>
					<SignInModal/>
				</Nav>
			</Navbar>
		</>
	)
}