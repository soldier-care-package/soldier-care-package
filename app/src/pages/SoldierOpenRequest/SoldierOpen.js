import React from "react"
import {Open} from "./Open-soldier";
import Button from "react-bootstrap/Button";

export const SoldierOpen = () => {
	return (
		<>
			<h1 className="mt-5 justify-content-center">Soldier Username Open Request</h1>

			<div className="mb-2 p-4">
				<Button className="m-2" variant="primary" size="lg">
					Posted
				</Button>{' '}
				<Button className="m-2" variant="secondary" size="lg">
					Pending/History
				</Button>
			</div>

			<Open/>
		</>
	)
}