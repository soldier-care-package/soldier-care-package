import React from "react"
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {SignUpModal} from "./sign-up/SignUpModal";
import {SignInModal} from "./sign-in/SignInModel";

export const Navigation = () => {
	return (
		<>
			<Navbar bg="primary" variant="dark">
				<Navbar.Brand href="#home" >Home</Navbar.Brand>
				<Nav className="mr-auto">
					<Nav.Link href="#home" size="lg">+</Nav.Link>
					<Nav.Link href="#features">My Lists</Nav.Link>
					<Nav.Link href="#pricing">Profile</Nav.Link>
					<SignUpModal/>
					<SignInModal/>
				</Nav>
			</Navbar>
		</>
	)
}