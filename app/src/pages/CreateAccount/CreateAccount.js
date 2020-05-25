import React from "react";
import Form from "react";
import Container from "react";
import Row from "react";
import Col from "react";
import Image from "react";
import Button from "react";

export const CreateAccount = () => {
	return (
<>
	<Form>
		<Container>
			<Row>
				<Col xs={6} md={4}>
					<Image src="holder.js/171x180" roundedCircle />
				</Col>
			</Row>
		</Container>
		<Form.Group controlId="exampleForm.ControlTextarea1">
			<Form.Label>Bio</Form.Label>
			<Form.Control as="Bio" rows="3" />
		</Form.Group>
		<Form.Group controlId="formGroupUsername">
			<Form.Label>Username</Form.Label>
			<Form.Control type="username" placeholder="Enter Username"/>
		</Form.Group>
		<Form.Group controlId="formGroupPassword">
			<Form.Label>Password</Form.Label>
			<Form.Control type="password" placeholder="Password"/>
		</Form.Group>
		<Form.Group controlId="formGroupEmail">
			<Form.Label>Email</Form.Label>
			<Form.Control type="email" placeholder="Enter Email"/>
		</Form.Group>
		<Form.Group controlId="formGroupFirstName">
			<Form.Label>First Name</Form.Label>
			<Form.Control type="first name" placeholder="Enter First Name"/>
		</Form.Group>
		<Form.Group controlId="formGroupLastName">
			<Form.Label>Last Name</Form.Label>
			<Form.Control type="last name" placeholder="Enter Last Name"/>
		</Form.Group>
		<Form.Group controlId="formGridProfileType">
			<Form.Label>Profile Type</Form.Label>
			<Form.Control as="select" value="Choose...">
				<option>Soldier...</option>
				<option>Sender...</option>
			</Form.Control>
		</Form.Group>
		<Form.Group controlId="formGroupMailingAddress">
			<Form.Label>Mailing Address</Form.Label>
			<Form.Control type="mailing address" placeholder="Enter Mailing Address"/>
		</Form.Group>
		<Button variant="outline-primary">Submit</Button>{' '}
	</Form>
	</>
	)
};
