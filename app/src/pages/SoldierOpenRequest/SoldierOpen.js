import React from "react"
import {Open} from "./Open-soldier";
import Button from "react-bootstrap/Button";
import Row from "react-bootstrap/Row";
import Container from "react-bootstrap/Container";

export const SoldierOpen = () => {
	return (
		<>
			<Container>
				<Row className="justify-content-center m-4">
					<h1>Solder LillyP Open Request</h1>
				</Row>
			</Container>

			<Container>
				<Row className="justify-content-center m-4">
					<div className="mb-2 p-4">
						<Button className="m-2" variant="primary" size="lg">
							Posted
						</Button>
						<Button className="m-2" variant="secondary" size="lg">
							Pending/History
						</Button>
					</div>
				</Row>
			</Container>

			<Open/>
		</>
	)
}