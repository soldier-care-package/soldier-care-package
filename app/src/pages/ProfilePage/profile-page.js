import React from "react";
import Form from "react-bootstrap/Form";
import Card from "react-bootstrap/Card";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Image from "react-bootstrap/Image";
import Button from "react-bootstrap/Button";

export const ProfilePage = () => {
	return (
		<>
			<Form>
				<Card>
					<Card.Body>(Username)</Card.Body>
					<Card.Body>(Profile Type)</Card.Body>
				</Card>
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
				<Button variant="outline-primary" size="lg" disabled>
					First Name
				</Button>{' '}
				<Card>
					<Card.Body>Lily</Card.Body>
				</Card>
				<Button variant="outline-primary" size="lg" disabled>
					Last Name
				</Button>{' '}
				<Card>
					<Card.Body>Poblano</Card.Body>
				</Card>
				<Button variant="outline-primary" size="lg" disabled>
					Mailing Address
				</Button>{' '}
				<Card>
					<Card.Body>PFC John Smith. PSC 1234, Box 12345. APO AE 09204-1234</Card.Body>
				</Card>
				<Button variant="outline-primary" size="lg" disabled>
					Email
				</Button>{' '}
				<Card>
					<Card.Body>ProfileEmail@google.com</Card.Body>
				</Card>
				<Button variant="outline-primary" size="lg" disabled>
					Password
				</Button>{' '}
				{/*<Button variant="outline-primary" size="lg" disabled>*/}
				{/*	Email*/}
				{/*</Button>{' '}*/}
				<Button variant="outline-primary">Edit Profile</Button>{' '}
			</Form>
		</>
	)
};
