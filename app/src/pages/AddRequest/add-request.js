import React from "react";
import Card from "react";
import ListGroup from "react";
import Button from "react";
import Form from "react";

export const AddRequest = () => {
	return (
		<>
			<Form>
				<Card>
					<Card.Body>(Username)</Card.Body>
				</Card>
				<Card>
				<ListGroup>
					<ListGroup.Item>Item One</ListGroup.Item>
					<ListGroup.Item variant="primary">Item Two</ListGroup.Item>
					<ListGroup.Item>Item Three</ListGroup.Item>
					<ListGroup.Item variant="primary">Item Four</ListGroup.Item>
				</ListGroup>
				</Card>
				<Card>
					<Card.Body>PFC John Smith. PSC 1234, Box 12345. APO AE 09204-1234</Card.Body>
				<Button variant="outline-primary" size="lg" disabled>
					Mailing Address
				</Button>{' '}
				<Button variant="outline-primary">Change</Button>{' '}
				</Card>
				<Button variant="outline-primary">Submit</Button>{' '}
			</Form>
		</>
	)
};
