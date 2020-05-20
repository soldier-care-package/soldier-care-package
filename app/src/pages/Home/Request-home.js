import React from "react"
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import ListGroup from "react-bootstrap/ListGroup";

export const Request = () => {
	return (
		<>
			<Card bg="primary" text="white"  border="dark" style={{ width: '25rem' }}>
				<Card.Img variant="top" src="picture-hold.jpg" alt="Profile picture"/>
				<Card.Body>
					<Card.Text>
						Soldier bio. Lorem ipsum dolor sit amet, consectetur adipiscing elit,
						sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nulla
						facilisi etiam dignissim diam quis. A iaculis at erat pellentesque adipiscing
						commodo elit at. Vitae suscipit tellus mauris a. Non curabitur gravida arcu ac.
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