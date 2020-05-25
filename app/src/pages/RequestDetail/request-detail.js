import React from "react";
import Form from "react-bootstrap/Form";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Image from "react-bootstrap/Image";
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import ListGroup from "react-bootstrap/ListGroup";


export const RequestDetail = () => {
	return (
		<>
			<Form>
				<Container>
					<Row>
						<Col xs={6} md={4}>
							<Image src="holder.js/171x180" roundedCircle />
						</Col>
					</Row>
					<Card>
						<Button variant="outline-primary" size="lg" disabled>
							Username
						</Button>{' '}
						<Button variant="outline-primary" size="lg" disabled>
							First Name
						</Button>{' '}
						<Button variant="outline-primary" size="lg" disabled>
							Last Name
						</Button>{' '}
						<Button variant="outline-primary" size="lg" disabled>
							Mailing Address
						</Button>{' '}
					</Card>
					<Card>
						<Form.Group controlId="exampleForm.ControlTextarea1">
							<Form.Label>Bio</Form.Label>
							<Form.Control as="Bio" rows="3" />
						</Form.Group>
					</Card>
					<Card>
						<ListGroup>
							<ListGroup.Item>Item One</ListGroup.Item>
							<ListGroup.Item variant="primary">Item Two</ListGroup.Item>
							<ListGroup.Item>Item Three</ListGroup.Item>
							<ListGroup.Item variant="primary">Item Four</ListGroup.Item>
						</ListGroup>
						<Button variant="outline-primary">Accept Whole List</Button>{' '}
					</Card>
				</Container>
			</Form>
		</>
	)
};
