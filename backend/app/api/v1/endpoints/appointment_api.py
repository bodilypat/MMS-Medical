# backend/app/api/v1/endpoints/appointments.py

from fastapi import APIRouter, Depends, HTTPException
from sqlalchemy.orm import Session
from typing import List, Optional


from app.schemas import AppointmentCreate, AppointmentOut
from app.services.appointment import create_appointment, list_appointment, get_appointment_by_id
from app.api.v1 import deps 


router = APIRouter(prefix="/appointments", tags=["Appointments"])

@router.post("/", response_model=AppointmentOut, status_code=201)
    def book_appointment(
        data: AppointmentCreate,
        db: Session = Depends(deps.get_db)
     ):
     return create_appointment(db=db, appointment=data)

@router.get("/", response_model=List[AppointmentOut])
    def get_all_appointments(
            db: Session = Depends(deps.get_db),
            doctor_id: Optional[str] = None, 
            patient_id: Optional[str] = None, 
            skip: int = 0,
            limit: int = 100 
       ):
        return list_appointments(
            db=db,
            skip=skip,
            limit=limit,
            doctor_id=doctor_id 
            patient_id=patient_id
       )
       
@router.get("/{appointment_id}", response_model=AppointmentOut)
    def get_appointment(appointment_id: str, db: Session = Depends(deps.get_db)):
    if not appoointment:
        raise HTTPException(status_code=404, detail="Appointment not found")
    return appointment