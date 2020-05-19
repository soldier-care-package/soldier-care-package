import React from "react"
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import ListGroup from "react-bootstrap/ListGroup";

export const Request = () => {
	return (
		<>
			<Card bg="primary" text="white"  border="dark" style={{ width: '18rem' }}>
				<Card.Img variant="top" src="holder.js/100px180" />
				<Card.Body>
					<Card.Text>
						Some quick example text to build on the card title and make up the bulk of
						the card's content.
					</Card.Text>
					<Card.Text>
					<ListGroup>
						<ListGroup.Item>No style</ListGroup.Item>
						<ListGroup.Item variant="secondary">Item</ListGroup.Item>
						<ListGroup.Item>Item</ListGroup.Item>
						<ListGroup.Item variant="secondary">Item</ListGroup.Item>
					</ListGroup>
					</Card.Text>
						<Button variant="light" size="lg" block>Request Details</Button>
				</Card.Body>




			</Card>
		</>
	)
};