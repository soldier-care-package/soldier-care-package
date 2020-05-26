import React from "react";
import Form from "react-bootstrap/Form";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Image from "react-bootstrap/Image";
import Button from "react-bootstrap/Button";

export const CreateAccount = () => {
	return (
<>
	<Form>
		<Container>
			<Row>
				<Col xs={6} md={4}>
					<Image src="https://picsum.photos/200/200" roundedCircle />
				</Col>
			</Row>
		</Container>
		<Container>
			<Form.Group controlId="exampleForm.ControlTextarea1">
				<Form.Label>Bio</Form.Label>
				<Form.Control as="Bio" rows="3" />
			</Form.Group>
		</Container>
		<Container>
			<Form.Group controlId="formGroupUsername">
				<Form.Label>Username</Form.Label>
				<Form.Control type="username" placeholder="Enter Username"/>
			</Form.Group>
		</Container>
		<Container>
			<Form.Group controlId="formGroupPassword">
				<Form.Label>Password</Form.Label>
				<Form.Control type="password" placeholder="Password"/>
			</Form.Group>
		</Container>
		<Container>
			<Form.Group controlId="formGroupEmail">
				<Form.Label>Email</Form.Label>
				<Form.Control type="email" placeholder="Enter Email"/>
			</Form.Group>
		</Container>
		<Container>
			<Form.Group controlId="formGroupFirstName">
				<Form.Label>First Name</Form.Label>
				<Form.Control type="first name" placeholder="Enter First Name"/>
			</Form.Group>
		</Container>
		<Container>
			<Form.Group controlId="formGroupLastName">
				<Form.Label>Last Name</Form.Label>
				<Form.Control type="last name" placeholder="Enter Last Name"/>
			</Form.Group>
		</Container>
		<Container>
			<Form.Group controlId="formGridProfileType">
				<Form.Label>Profile Type</Form.Label>
				<Form.Control as="select" value="Choose...">
					<option>Soldier</option>
					<option>Sender</option>
				</Form.Control>
			</Form.Group>
		</Container>
		<Container>
			<Form.Group controlId="formGroupMailingAddress">
				<Form.Label>Mailing Address</Form.Label>
				<Form.Control type="mailing address" placeholder="Enter Mailing Address"/>
			</Form.Group>
		</Container>
		<Container>
			<Button variant="outline-primary">Submit</Button>{' '}
		</Container>
	</Form>
	</>
	)
};
