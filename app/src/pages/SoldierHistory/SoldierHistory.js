import React from "react"
import {History} from "./History-request";
import Button from "react-bootstrap/Button";
import Container from "react-bootstrap/Container";


export const SoldierHistory = () => {
	return (
		<>
			<Container>
			<h1>Soldier Username Fulfilled Request History</h1>
			</Container>
					<div className="mb-2 p-4">
						<Button className="m-2" variant="secondary" size="lg">
							Posted
						</Button>{' '}
						<Button className="m-2" variant="primary" size="lg">
							Pending/History
						</Button>
					</div>
			<History/>
		</>
	)
}