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
				<Container>
					<Row>
						<h1 className="justify-content-center m-5">(Username)</h1>
					</Row>
					<Row>
						<h1 className="justify-content-center m-5">(Profile Type)</h1>
					</Row>

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
					<Row>
						<Button variant="outline-primary" size="lg" disabled>
							First Name
						</Button>{' '}
						<Card>
							<Card.Body>Lily</Card.Body>
						</Card>
					</Row>
				</Container>
				<Container>
					<Row>
						<Button variant="outline-primary" size="lg" disabled>
							Last Name
						</Button>{' '}
						<Card>
							<Card.Body>Poblano</Card.Body>
						</Card>
					</Row>
				</Container>
				<Container>
					<Row>
						<Button variant="outline-primary" size="lg" disabled>
							Mailing Address
						</Button>{' '}
						<Card>
							<Card.Body>PFC John Smith. PSC 1234, Box 12345. APO AE 09204-1234</Card.Body>
						</Card>
					</Row>
				</Container>
				<Container>
					<Row>
						<Button variant="outline-primary" size="lg" disabled>
							Email
						</Button>{' '}
						<Card>
							<Card.Body>ProfileEmail@google.com</Card.Body>
						</Card>
					</Row>
				</Container>
				<Container>
					<Row>
						<Button variant="outline-primary" size="lg" disabled>
							Password
						</Button>{' '}
						<Button variant="outline-primary" size="lg" disabled>
								*************
						</Button>{' '}
					</Row>
				</Container>
				<Container>
					<Row>
						<Button variant="outline-primary">Edit Profile</Button>{' '}
					</Row>
				</Container>
			</Form>
		</>
	)
};
