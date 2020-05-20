import React from "react"
import Card from "react-bootstrap/Card";
import ListGroup from "react-bootstrap/ListGroup";
import Button from "react-bootstrap/Button";

export const Open = () => {
	return (
		<>
			<Card bg="primary" text="white"  border="dark" style={{ width: '25rem' }}>
				<Card.Img variant="top" src="picture-hold.jpg" alt="Profile picture" />
				<Card.Body>
					<Card.Text>
						Soldier bio.
					</Card.Text>
					<Card.Text>
						<ListGroup>
							<ListGroup.Item>No style</ListGroup.Item>
							<ListGroup.Item variant="secondary">Item</ListGroup.Item>
							<ListGroup.Item>Item</ListGroup.Item>
							<ListGroup.Item variant="secondary">Item</ListGroup.Item>
						</ListGroup>
					</Card.Text>
					<Button variant="light" size="lg" block>Edit/Delete</Button>
				</Card.Body>
			</Card>
		</>
	)
}